;(function(){
    var style = '[style]',
        htmlInner  = '[html]',
        url = '[url]',
        key = '[key]',
        sop =  parseInt('[sop]'),
        swe =  parseInt('[swe]'),
        color = '[color]',
        yandex_cn = '[yandex_cn]',
        yandex_goal = '[yandex_goal]',
        page_count = [page_count],
        client_count_show = [client_count_show],
        visit_count  = [visit_count],
        site_time  = [site_time];

    var body = document.body,
        html = document.documentElement,
        height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );


    function doNotShowPopup()
    {
        sessionStorage.setItem('DoNotShowPopup',true);
    }

    function canShowPopup()
    {
        return !sessionStorage.hasOwnProperty('DoNotShowPopup');
    }


    function setDataCallerAttribute(caller)
    {
        document.getElementById('cc-popup').dataset.caller = caller;
    }

    function cPopupClose(){
        document.getElementById("cc-popup").style.display="none";
        document.getElementById("cc-popup-shadow").style.display="none";
    }

    function cPopupOpen(){
        document.getElementById("cc-popup").style.display="block";
        document.getElementById("cc-popup-shadow").style.display="block";
        var focusC =  document.getElementById("cc-phone").value;
        document.getElementById("cc-phone").focus();
        cSetEnd(document.getElementById("cc-phone"));

    }

    //Курсор в конец
    function cSetEnd(txt) {
        if (txt.createTextRange) {
            var FieldRange = txt.createTextRange();
            FieldRange.moveStart("character", txt.value.length);
            FieldRange.collapse();
            FieldRange.select();
        }else{
            txt.focus();
            var length = txt.value.length;
            txt.setSelectionRange(length, length);
        }
    }

    //Отправка звонка
    function cSendCall(){

        if( eval("typeof yaCounter"+yandex_cn) != "undefined") {eval("yaCounter"+yandex_cn).reachGoal(yandex_goal);}

        document.getElementById("cc-error").innerHTML="";
        var phone =document.getElementById("cc-phone").value;
        if(!/^\+7[0-9]{10}$/.test(phone)){
            document.getElementById("cc-error").innerHTML="Неверный формат телефона: Телефон должен начинаться с +7 и содержать только цифры";
            return false;
        }
        document.getElementById("cc-call").style.display = "none";
        document.getElementById("cc-call1").style.display = "inline-block";
        setTimeout(cTimerDown,1000);
        var r = new XMLHttpRequest();
        r.open("GET",url+"?phone="+phone+"&key="+key+"", true);
        r.onreadystatechange = function () {
            if (r.readyState != 4 || r.status != 200) return;
        };
        r.send();
    }

    //Таймер отчета
    function cTimerDown(){
        document.getElementById("cc-timer").style.color = color;
        var timer = parseInt(document.getElementById("cc-timer").innerHTML);
        document.getElementById("cc-timer").innerHTML = timer-1;
        if(timer>1) setTimeout(cTimerDown,1000);
    }


    //Время на сайте
    function cSiteTime()
    {

        if(sessionStorage.hasOwnProperty('showBySiteTimer')){
            return true;
        }



        var sTime = null;
        if(sessionStorage.hasOwnProperty('siteShowTimer')) {
            sTime = parseInt(sessionStorage.getItem('siteShowTimer'));
        }

        clearTimeout(ssTimeVar);

        if( sTime==parseInt(site_time))  {
            sessionStorage.setItem('showBySiteTimer',1)
            doNotShowPopup();
            setDataCallerAttribute('site_timer')
            cPopupOpen();
            return true;
        }



        ssTimeVar = setTimeout(function(){
            sTime= sTime+1;
            sessionStorage.setItem('siteShowTimer',sTime);
            cSiteTime();
        },1000);

    }

    //Таймер бездействия
    function noEventOpenCall(){
        clearTimeout(idleTimer);
        idleState = false;
        idleTimer = setTimeout(function () {
            idleState = true;
            if(!canShowPopup()) return false;
            setDataCallerAttribute('no_event');
            doNotShowPopup();
            cPopupOpen();
        }, idleWait);
    }

    //Кол-во страниц
    function pageCountShow(){
        if(sessionStorage.hasOwnProperty('page_count'))
        {

            var arr = JSON.parse(sessionStorage.getItem('page_count'))

            if (arr.length + 1 == page_count)
            {
                doNotShowPopup();
                setDataCallerAttribute('page_count');
                cPopupOpen();
            }

            if(arr.indexOf(location.pathname)==-1)
            {
                arr.push(location.pathname);
            }
            sessionStorage.setItem('page_count',JSON.stringify(arr));
        }else{
            var arr = [];
            arr.push(location.pathname);
            sessionStorage.setItem('page_count',JSON.stringify(arr));
        }

    }

    //Кол-во визитов
    function visitCountShow(){
        if(localStorage.hasOwnProperty('visit_count'))
        {

            if(!sessionStorage.hasOwnProperty('visit_count'))
            {
                localStorage.setItem('visit_count', parseInt(localStorage.getItem('visit_count'))+1);

            }

            if (!sessionStorage.hasOwnProperty('visit_count') && localStorage.getItem('visit_count') == visit_count)
            {
                setDataCallerAttribute('visit_count');
                doNotShowPopup();
                cPopupOpen();
            }

            if(!sessionStorage.hasOwnProperty('visit_count')) sessionStorage.setItem('visit_count',1);

        }else{
            localStorage.setItem('visit_count',1);
            sessionStorage.setItem('visit_count',1);
        }
    }

    document.body.insertAdjacentHTML('beforeend',style+htmlInner);

    //Таймер время на сайте
    var ssTimeVar = null;
    if(typeof site_time != "undefined")
    {
        var ssTimeVar = null;
        cSiteTime();
    }

    //Таймер бездействия в ноль
    var idleTimer = null;
    var idleState = false;
    var idleWait = swe;

    document.addEventListener('mousemove',noEventOpenCall);
    document.addEventListener('keydown',noEventOpenCall);
    document.addEventListener('scroll',noEventOpenCall);
    document.addEventListener('touchstart',noEventOpenCall);


    //Кол-во просмотренных страниц
    if(typeof page_count != "undefined")
    {
        pageCountShow();
    }

    //Кол-во визитов
    if(typeof visit_count != "undefined")
    {
        visitCountShow();
    }


    document.getElementById("cc-popup-shadow").style.height=height;
    document.getElementById("cc-phone-button").onclick = cPopupOpen;
    document.getElementById("cc-close").onclick = cPopupClose;
    document.getElementById("cc-call").onclick = cSendCall;

    window.setTimeout(function(){
        if(!canShowPopup()) return false;
        doNotShowPopup();
        cPopupOpen();

    },sop);
})();