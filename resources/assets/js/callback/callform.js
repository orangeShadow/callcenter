;(function(){

    var BreakException = {
        'message':'Foreach break'
    };

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

    var debug = false;

    var Helper = {
        cursorSetEnd :  function(txt) {
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
        },

        log: function(data){
            if(debug){
                console.log(data);
            }
        },
        validateEmail:function(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        }
    };

    var HtmlEvent = {
        timerId : 0,
        canPopupShow: function(initiator){

            if (initiator =='client-click') {
                this.setPopupShowOff();
                return true;
            }

            if ( localStorage.hasOwnProperty('client_count_show') &&  localStorage.getItem('client_count_show')>=client_count_show)
            {
                Helper.log('canPopupShow: Выключен так как уже был показан: '+localStorage.getItem('client_count_show')+' раз.');
                return false;
            }

            //Можно показать форму?
            if( (initiator =='start-page-time' || initiator=='no-event') && sessionStorage.hasOwnProperty('ccPopupShow') && sessionStorage.getItem('ccPopupShow')==0 ){
                Helper.log('canPopupShow: Выключен так как уже был показан: при загрузке страницы (1 раз, больше не показываем)');
                return false;
            }

            return true;
        },

        setPopupShowOn: function(){
            //Разрешить показ формы
            sessionStorage.setItem('ccPopupShow',1);
        },

        setPopupShowOff: function(){
            //Запретить показ формы
            sessionStorage.setItem('ccPopupShow',0);
        },

        setPopupInitiator: function(initiator){
            //Установить событие-инициатор открытия формы
            document.getElementById('cc-popup').dataset.initiator = initiator;
        },

        getPopupInitiator: function(){
            //Полчить событие-инициатор открытия формы
            return document.getElementById('cc-popup').getAttribute('data-initiator');
        },

        popupOpen: function(initiator){
            //Открываем popup

            Helper.log('popupOpen: инициатор:'+initiator);

            this.setPopupInitiator(initiator);

            //Выходим если форму показать нельзя
            if(!this.canPopupShow(initiator)) return false;

            if(typeof client_count_show != "undefined" && initiator != "client-click")
            {
                var ccs = localStorage.hasOwnProperty('client_count_show') ? parseInt(localStorage.getItem('client_count_show')):0;
                localStorage.setItem('client_count_show',ccs+1);
            }

            //Устанавливаем что при заходе на странцу уже показали
            if(initiator =='start-page-time') this.setPopupShowOff();

            document.getElementById("cc-popup").style.display="block";
            document.getElementById("cc-popup-shadow").style.display="block";
            document.getElementById("cc-phone").focus();
            Helper.cursorSetEnd(document.getElementById("cc-phone"));
        },

        popupClose: function(){
            //Закрываем попап
            document.getElementById("cc-popup").style.display="none";
            document.getElementById("cc-popup-shadow").style.display="none";
        },

        sendCall: function(){
            //Отправка звонка

            if( eval("typeof yaCounter"+yandex_cn) != "undefined") {eval("yaCounter"+yandex_cn).reachGoal(yandex_goal);}

            document.getElementById("cc-error").innerHTML="";
            var phone =document.getElementById("cc-phone").value;
            if(!/^\+7[0-9]{10}$/.test(phone)){
                document.getElementById("cc-error").innerHTML="Неверный формат телефона: Телефон должен начинаться с +7 и содержать только цифры";
                return false;
            }
            document.getElementById("cc-call").style.display = "none";
            document.getElementById("cc-call1").style.display = "inline-block";
            this.timerId = setTimeout(HtmlEvent.timerDown,1000);
            var r = new XMLHttpRequest();
            r.open("GET",url+"?phone="+phone+"&key="+key+"&initiator="+HtmlEvent.getPopupInitiator(), true);
            r.onreadystatechange = function () {
                if (r.readyState != 4 || r.status != 200) return;
                try{
                    var data = r.responseText;
                    data = JSON.parse(data);
                    console.log(data);
                    console.log(data.result);

                    if( typeof data.result == "object" )
                    {
                       //clearTimeout(HtmlEvent.timerId);
                    }

                }catch(e)
                {
                    Helper.log('Ошибка ' + e.name + ":" + e.message + "\n" + e.stack);
                }
            };
            r.send();
        },

        sendMessage: function(){
            document.getElementById("cc-message-error").innerHTML="";
            var name =document.getElementById("cc-name").value.trim();
            var email =document.getElementById("cc-email").value.trim();
            var mess = document.getElementById("cc-message").value.trim();
            if(!Helper.validateEmail(email)){
                document.getElementById("cc-message-error").innerHTML="Неверный формат email.";
                return false;
            }

            if(name.length==0 || email.length==0 || mess.length == 0){
                document.getElementById("cc-message-error").innerHTML="Для отправки сообщения необходимо заполнить все поля.";
                return false;
            }
            document.getElementById("cc-message-btn-send").style.display = "none";

            var r = new XMLHttpRequest();
            var body = "text="+mess+"&name="+name+"&email="+email;
            r.open("POST",url+"?key="+key+"&initiator="+HtmlEvent.getPopupInitiator(), true);

            r.onreadystatechange = function () {
                if (r.readyState != 4 || r.status != 200) return;
                try{
                    var data = r.responseText;
                    data = JSON.parse(data);
                    console.log(data.success);
                    if (typeof data.success != "undefined" && data.success=="y")
                    {
                        document.getElementsByClassName('cc-content-message')[0].innerHTML = '<p class="success">Ваше сообщение отправлено. Спасибо за обращение.</p>';
                    }

                }catch(e)
                {
                    Helper.log('Ошибка ' + e.name + ":" + e.message + "\n" + e.stack);
                }
            };
            r.send(body);
        },

        timerDown: function(){
            document.getElementById("cc-timer").style.color = color;
            var timerCnt = parseInt(document.getElementById("cc-timer").innerHTML);
            document.getElementById("cc-timer").innerHTML = timerCnt-1;
            if(timerCnt>1) HtmlEvent.timerId=setTimeout(HtmlEvent.timerDown,1000);
        }
    };

    var CallCenterEvent = {

        siteTime : function(){
            //Время нахождения на сайте

            var sTime = null;
            clearTimeout(ssTimeVar);

            if(sessionStorage.hasOwnProperty('siteShowTimer')) {
                sTime = parseInt(sessionStorage.getItem('siteShowTimer'));
            }

            if( sTime==parseInt(site_time))  {
                HtmlEvent.popupOpen('site-timer');
                sessionStorage.setItem('siteShowTimer',sTime+1);
            }else if(sTime<parseInt(site_time)){
                ssTimeVar = setTimeout(function(){
                    sTime= sTime+1;
                    sessionStorage.setItem('siteShowTimer',sTime);
                        CallCenterEvent.siteTime();
                },1000);
            }
        },

        noEvent: function() {
            clearTimeout(idleTimer);
            idleState = false;
            idleTimer = setTimeout(function () {
                idleState = true;
                HtmlEvent.popupOpen('no-event');
            }, idleWait);
        },

        pageCountShow: function() {
            // Показ от числа просмотренных страниц
            if(sessionStorage.hasOwnProperty('page_count'))
            {

                var arr = JSON.parse(sessionStorage.getItem('page_count'))
                var addNow = false;
                if(arr.indexOf(location.pathname)==-1)
                {
                    arr.push(location.pathname);
                    addNow==true
                }
                sessionStorage.setItem('page_count',JSON.stringify(arr));

                if (arr.length == page_count && addNow)
                {
                    Helper.log('Запустил функцию показа по числу просмотренных страниц');
                    HtmlEvent.popupOpen('page-count');
                }

            }else{
                var arr = [];
                arr.push(location.pathname);
                sessionStorage.setItem('page_count',JSON.stringify(arr));
            }

            return false;
        },

        visitCountShow: function(){
            //Кол-во визитов на сайт

            if(localStorage.hasOwnProperty('visit_count') && !sessionStorage.hasOwnProperty('visit_count'))
            {
                localStorage.setItem('visit_count', parseInt(localStorage.getItem('visit_count'))+1);
                sessionStorage.setItem('visit_count',1)
            }else{
                localStorage.setItem('visit_count',1);
                sessionStorage.setItem('visit_count',1);
            }

            if(localStorage.getItem('visit_count') == visit_count)
            {
                Helper.log('Запустил функцию показа по числу посещений');
                HtmlEvent.popupOpen('visit-count');
            }

            return false;
        }

    };

    document.body.insertAdjacentHTML('beforeend',style+htmlInner);



    //Установка переменных в начальное положение
    var ssTimeVar = null;
    var idleTimer = null;
    var idleState = false;
    var idleWait = swe;

    //Запускаем Таймер время на сайте
    if(typeof site_time != "undefined")
    {
        CallCenterEvent.siteTime();
    }

    document.addEventListener('mousemove',CallCenterEvent.noEvent);
    document.addEventListener('keydown',CallCenterEvent.noEvent);
    document.addEventListener('scroll',CallCenterEvent.noEvent);
    document.addEventListener('touchstart',CallCenterEvent.noEvent);


    //Кол-во просмотренных страниц
    if(typeof page_count != "undefined")
    {
        CallCenterEvent.pageCountShow();
    }

    //Кол-во визитов
    if(typeof visit_count != "undefined")
    {
        CallCenterEvent.visitCountShow();
    }

    document.getElementsByTagName('body')[0].addEventListener("click",function(e){
        try{
            var path = e.path;
            var exit = true;
            if(document.getElementById('cc-popup').style.display=="none"){
                exit = false;
            }

            var el = e.target.parentElement;
            while(el.parentElement != null)
            {
                if(el.id=="cc-popup") {exit = false;  break;}
                if(el.id=="cc-phone-button-wrap") {exit = false; break;}
                el=el.parentElement;
            }


            if(exit){
                HtmlEvent.popupClose();
            }
        }catch(e){
            Helper.log(e);
        }
    });

    document.getElementById("cc-popup-shadow").style.height=height;
    document.getElementById("cc-phone-button").onclick = function(){HtmlEvent.popupOpen('client-click');};
    document.getElementById("cc-close").onclick = HtmlEvent.popupClose;

    document.getElementById("cc-call").onclick = HtmlEvent.sendCall;
    document.getElementById('cc-message-btn-send').onclick = HtmlEvent.sendMessage;

    document.getElementById('cc-message-btn').addEventListener('click',function(e){
        console.log(e);
        e.target.parentNode.style.display = "none";
        e.target.parentNode.nextElementSibling.style.display = "block";
        document.getElementsByClassName('cc-content')[0].style.display = "none";
        document.getElementsByClassName('cc-content-message')[0].style.display = "block";
    });




    document.getElementById('cc-phone-btn').addEventListener('click',function(e){
        console.log(e);
        e.target.parentNode.style.display = "none";
        e.target.parentNode.previousElementSibling.style.display = "block";
        document.getElementsByClassName('cc-content')[0].style.display = "block";
        document.getElementsByClassName('cc-content-message')[0].style.display = "none";
    });

    if(typeof sop != 'undefined')
    {
        window.setTimeout(function(){
            HtmlEvent.popupOpen('start-page-time');
        },sop);

    }

})();