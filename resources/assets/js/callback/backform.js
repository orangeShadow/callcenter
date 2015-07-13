;(function(){
    var style = '[style]',
        htmlInner  = '[html]',
        url = '[url]',
        key = '[key]',
        color = '[color]',
        yandex_cn = '[yandex_cn]',
        yandex_goal = '[yandex_goal]';

    var body = document.body,
        html = document.documentElement,
        height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );

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
        }
    };

    var debug = false;

    var HtmlEvent = {

        canPopupShow: function(initiator){

            if (initiator =='client-click') return true;

            if ( localStorage.hasOwnProperty('client_count_show') &&  localStorage.getItem('client_count_show')>=client_count_show)
            {
                Helper.log('canPopupShow: Выключен так как уже был показан: '+localStorage.getItem('client_count_show')+' раз.');
                return false;
            }

            //Можно показать форму?
            if( initiator =='start-page-time' && sessionStorage.hasOwnProperty('ccPopupShow') && sessionStorage.getItem('ccPopupShow')==0 ){
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
                try{
                    var data = r.responseText;
                    data = JSON.parse(data);
                    if(data.error==1)
                    {
                        alert(data.message);
                    }
                }catch(e)
                {
                    console.log(e);
                }
            };
            r.send();
        },

        timerDown: function(){
            document.getElementById("cc-timer").style.color = color;
            var timer = parseInt(document.getElementById("cc-timer").innerHTML);
            document.getElementById("cc-timer").innerHTML = timer-1;
            if(timer>1) setTimeout(HtmlEvent.cTimerDown,1000);
        }
    };



    document.body.insertAdjacentHTML('beforeend',style+htmlInner);

    document.getElementById("cc-popup-shadow").style.height=height;
    document.getElementById("cc-phone-button").onclick = function(){HtmlEvent.popupOpen('client-click');};
    document.getElementById("cc-close").onclick = HtmlEvent.popupClose;
    document.getElementById("cc-call").onclick = HtmlEvent.sendCall;

})();