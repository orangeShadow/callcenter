;(function(){
    var style = '[style]';
    var htmlInner  = '[html]';
    var url = '[url]';
    var key = '[key]';
    var sop =  parseInt('[sop]');
    var swe =  parseInt('[swe]');
    var color = '[color]';
    var yandex_cn = '[yandex_cn]';
    var yandex_goal = '[yandex_goal]';

    var body = document.body;
    var html = document.documentElement;
    var height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );


    function cPopupClose(){
        document.getElementById("cc-popup").style.display="none";
        document.getElementById("cc-popup-shadow").style.display="none";
        if(localStorage.hasOwnProperty('cc-call')==false){
            localStorage.setItem('cc-call',1);
        }
    }
    function cPopupOpen(){
        document.getElementById("cc-popup").style.display="block";
        document.getElementById("cc-popup-shadow").style.display="block";
        var focusC =  document.getElementById("cc-phone").value;
        document.getElementById("cc-phone").focus();
        cSetEnd(document.getElementById("cc-phone"));

    }

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

    function cTimerDown(){
        document.getElementById("cc-timer").style.color = color;
        var timer = parseInt(document.getElementById("cc-timer").innerHTML);
        document.getElementById("cc-timer").innerHTML = timer-1;
        if(timer>1) setTimeout(cTimerDown,1000);
    }



    function noEventOpenCall(){
        clearTimeout(idleTimer);
        idleState = false;
        idleTimer = setTimeout(function () {
            idleState = true;
            if(localStorage.hasOwnProperty('cc-call') && localStorage.getItem('cc-call')==1) return false;
            cPopupOpen();
        }, idleWait);
    }

    var idleTimer = null;
    var idleState = false;
    var idleWait = swe;

    document.addEventListener('mousemove',noEventOpenCall);
    document.addEventListener('keydown',noEventOpenCall);
    document.addEventListener('scroll',noEventOpenCall);
    document.addEventListener('touchstart',noEventOpenCall);

    document.body.insertAdjacentHTML('beforeend',style+htmlInner);

    document.getElementById("cc-popup-shadow").style.height=height;
    document.getElementById("cc-phone-button").onclick = cPopupOpen;
    document.getElementById("cc-close").onclick = cPopupClose;
    document.getElementById("cc-call").onclick = cSendCall;

    window.setTimeout(function(){
        if(localStorage.hasOwnProperty('cc-call') && localStorage.getItem('cc-call')==1) return false;
        cPopupOpen();
    },sop);
})();