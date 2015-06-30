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


    function cSendBackForm(){
        document.getElementById("cc-error").style.visibility="hidden";
        var phone =document.getElementById("cc-phone").value;
        var time  =document.getElementById("cc-time").value;
        if(!/^\+7[0-9]{10}$/.test(phone)){
            document.getElementById("cc-error").style.visibility="visible";
            return false;
        }
        document.getElementsByClassName("cc-content")[0].innerHTML= "Спасибо за обращение, нащи менеджеры свяжутся с вами";
        document.getElementsByClassName("cc-content")[0].style.lineHeight = "259px";
        document.getElementsByClassName("cc-content")[0].style.fontSize = "20px";
        document.getElementsByClassName("cc-content")[0].style.textAlign= "center";
        var r = new XMLHttpRequest();
        r.open("GET",url+"?key="+key+"&phone="+phone+"&time="+time, true);
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
    document.getElementById("cc-call").onclick = cSendBackForm;

    window.setTimeout(function(){
        if(localStorage.hasOwnProperty('cc-call') && localStorage.getItem('cc-call')==1) return false;
        cPopupOpen();
    },sop);
})();