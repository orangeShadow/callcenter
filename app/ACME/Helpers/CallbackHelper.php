<?php 
namespace App\ACME\Helpers;

use \Request;

class CallbackHelper {

    private static function styleStat($color="#009321"){
        return "
            #cc-phone-button-wrap{
                width:160px;
                height:160px;
                position: fixed;
                top:20%;
                right:10px;
                margin-top: -80px;
                text-align: center;
                vertical-align: middle;
                z-index: 1000;
                overflow: hidden;
            }

             #cc-phone-button{
                display: block;
                border-radius: 100%;
                position: absolute;
                top: 50px;
                left: 50px;
                z-index: 1000;
                width:60px;
                height:60px;
                cursor:pointer;
                background: $color url(\"http://".$_SERVER['SERVER_NAME']."/i/phone.png\") no-repeat center;
                animation: vibro 3s infinite ;
                -webkit-animation: vibro 3s infinite ;
                -moz-animation: vibro 3s infinite ;
                -ms-animation: vibro 3s infinite ;
                -o-animation: vibro 3s infinite ;
             }

                @keyframes vibro {
                  0% {
                    transform: rotate(0deg)
                  }
                  10% {
                    transform: rotate(-15deg)
                  }

                  15% {
                    transform: rotate(15deg)
                  }
                  16% {
                    transform: rotate(0deg)
                  }
                  94% {
                    transform: rotate(0deg)
                  }
                  95% {
                    transform: rotate(-15deg)
                  }
                  100% {
                    transform: rotate(20deg)
                  }
                }

                @-webkit-keyframes vibro {
                  0% {
                    transform: rotate(0deg)
                  }
                  10% {
                    transform: rotate(-15deg)
                  }

                  15% {
                    transform: rotate(15deg)
                  }
                  16% {
                    transform: rotate(0deg)
                  }
                  94% {
                    transform: rotate(0deg)
                  }
                  95% {
                    transform: rotate(-15deg)
                  }
                  100% {
                    transform: rotate(20deg)
                  }
                }

                @-moz-keyframes vibro {
                  0% {
                    transform: rotate(0deg)
                  }
                  10% {
                    transform: rotate(-15deg)
                  }

                  15% {
                    transform: rotate(15deg)
                  }
                  16% {
                    transform: rotate(0deg)
                  }
                  94% {
                    transform: rotate(0deg)
                  }
                  95% {
                    transform: rotate(-15deg)
                  }
                  100% {
                    transform: rotate(20deg)
                  }
                }

                @-ms-keyframes vibro {
                  0% {
                    transform: rotate(0deg)
                  }
                  10% {
                    transform: rotate(-15deg)
                  }

                  15% {
                    transform: rotate(15deg)
                  }
                  16% {
                    transform: rotate(0deg)
                  }
                  94% {
                    transform: rotate(0deg)
                  }
                  95% {
                    transform: rotate(-15deg)
                  }
                  100% {
                    transform: rotate(20deg)
                  }
                }

                @-o-keyframes vibro {
                  0% {
                    transform: rotate(0deg)
                  }
                  10% {
                    transform: rotate(-15deg)
                  }

                  15% {
                    transform: rotate(15deg)
                  }
                  16% {
                    transform: rotate(0deg)
                  }
                  94% {
                    transform: rotate(0deg)
                  }
                  95% {
                    transform: rotate(-15deg)
                  }
                  100% {
                    transform: rotate(20deg)
                  }
                }

                #cc-popup-shadow{
                    position: fixed;
                    _position:absolute;
                    left: 0;
                    top: 0;
                    _top:expression(eval(document.body.scrollTop));
                    width: 100%;
                    height: 100%;
                    z-index: 10000;
                    background: rgba(0, 0, 0, 0.8);
                    display: none;
                }
                #cc-popup{
                    width:700px;
                    height:298px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    position: fixed;
                    _position:absolute;
                    z-index:10005;
                    left: 50%;
                    top:50%;
                    _top:expression(eval(document.body.scrollTop));
                    margin-top:-150px;
                    margin-left: -351px;
                    overflow: hidden;
                    font-family: arial, Helvetica, sans-serif;
                    line-height:normal;
                    box-sizing: border-box;
                    display: none;
                }
                #cc-popup .cc-content{
                    position:relative;
                    height:259px;
                    background-color: #ededed;
                }

                #cc-popup .cc-close{
                    position: absolute;
                    right: 0;
                    top: 0;
                    width: 41px;
                    height:41px;
                    background: #566473 url(\"http://".$_SERVER['SERVER_NAME']."/i/close.png\") no-repeat center;
                    cursor: pointer;
                    z-index:2000;
                }

                #cc-popup .cc-close:hover{
                    background-color:$color;
                }
        ";
    }

    private static function getColorScheme($colorScheme)
    {
        switch($colorScheme)
        {
            case 1:
                return "#009321";
                break;
            case 2:
                return "#FED440";
                break;
            default:
                return "#009321";
                break;
        }

    }

    public static function getCallBackForm($client)
    {
        $miliseconds = (int)Request::get('sec',90000);
        $color = static::getColorScheme((int)Request::get('color',1));

        $style="<style>
            #r1 {
                z-index: 100;
                position: absolute;
                top:42px;
                left:42px;
                width:76px;
                height:76px;
                -webkit-animation-delay: -4s;
                -moz-animation-delay: -4s;
                -ms-animation-delay: -4s;
                -o-animation-delay: -4s;
                animation-delay: -4s;
            }
            #r2 {
                z-index: 50;
                position: absolute;
                top:30px;
                left:30px;
                width:96px;
                height:96px;
                -webkit-animation-delay: -4s;
                -moz-animation-delay: -4s;
                -ms-animation-delay: -4s;
                -o-animation-delay: -4s;
                animation-delay: -4s;
            }
            #r3 {
                z-index: 10;
                position: absolute;
                top:10px;
                left:10px;
                width:136px;
                height:136px;
                -webkit-animation-delay: -4s;
                -moz-animation-delay: -4s;
                -ms-animation-delay: -4s;
                -o-animation-delay: -4s;
                animation-delay: -4s;
            }
            #r4 {
                z-index: 20;
                position: absolute;
                top:0px;
                left:0px;
                width:156px;
                height:156px;
                -webkit-animation-delay: -4s;
                -moz-animation-delay: -4s;
                -ms-animation-delay: -4s;
                -o-animation-delay: -4s;
                animation-delay: -4s;
            }

            .ring {
                border-radius: 100%;
                -webkit-animation-name: ani;
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-timing-function: linear;
                -webkit-animation-duration: 8s;
                -webkit-animation-direction: normal;

                -moz-animation-name: ani;
                -moz-animation-iteration-count: infinite;
                -moz-animation-timing-function: linear;
                -moz-animation-duration: 8s;
                -moz-animation-direction: normal;


                -ms-animation-name: ani;
                -ms-animation-iteration-count: infinite;
                -ms-animation-timing-function: linear;
                -ms-animation-duration: 8s;
                -ms-animation-direction: normal;

                -o-animation-name: ani;
                -o-animation-iteration-count: infinite;
                -o-animation-timing-function: linear;
                -o-animation-duration: 8s;
                -o-animation-direction: normal;

                animation-name: ani1;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
                animation-duration: 8s;
                animation-direction: normal;
                background-color: $color;
            }

            .ring2 {
                border-radius: 100%;
                background-color: transparent;
                -webkit-animation-name: ani2;
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-timing-function: linear;
                -webkit-animation-duration: 8s;
                -webkit-animation-direction: normal;

                -moz-animation-name: ani2;
                -moz-animation-iteration-count: infinite;
                -moz-animation-timing-function: linear;
                -moz-animation-duration: 8s;
                -moz-animation-direction: normal;


                -ms-animation-name: ani2;
                -ms-animation-iteration-count: infinite;
                -ms-animation-timing-function: linear;
                -ms-animation-duration: 8s;
                -ms-animation-direction: normal;

                -o-animation-name: ani2;
                -o-animation-iteration-count: infinite;
                -o-animation-timing-function: linear;
                -o-animation-duration: 8s;
                -o-animation-direction: normal;


                animation-name: ani2;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
                animation-duration: 8s;
                animation-direction: normal;
                border: 2px solid $color;
            }

            .ring3 {
                border-radius: 100%;
                background-color: transparent;
                -webkit-animation-name: ani3;
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-timing-function: linear;
                -webkit-animation-duration: 8s;
                -webkit-animation-direction: normal;

                -moz-animation-name: ani3;
                -moz-animation-iteration-count: infinite;
                -moz-animation-timing-function: linear;
                -moz-animation-duration: 8s;
                -moz-animation-direction: normal;


                -ms-animation-name: ani3;
                -ms-animation-iteration-count: infinite;
                -ms-animation-timing-function: linear;
                -ms-animation-duration: 8s;
                -ms-animation-direction: normal;

                -o-animation-name: ani3;
                -o-animation-iteration-count: infinite;
                -o-animation-timing-function: linear;
                -o-animation-duration: 8s;
                -o-animation-direction: normal;

                animation-name: ani3;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
                animation-duration: 8s;
                animation-direction: normal;
                border: 2px solid $color;
            }

            .ring4 {
                border-radius: 100%;
                background-color: transparent;
                -webkit-animation-name: ani4;
                -webkit-animation-iteration-count: infinite;
                -webkit-animation-timing-function: linear;
                -webkit-animation-duration: 8s;
                -webkit-animation-direction: normal;

                -moz-animation-name: ani4;
                -moz-animation-iteration-count: infinite;
                -moz-animation-timing-function: linear;
                -moz-animation-duration: 8s;
                -moz-animation-direction: normal;


                -ms-animation-name: ani4;
                -ms-animation-iteration-count: infinite;
                -ms-animation-timing-function: linear;
                -ms-animation-duration: 8s;
                -ms-animation-direction: normal;

                -o-animation-name: ani4;
                -o-animation-iteration-count: infinite;
                -o-animation-timing-function: linear;
                -o-animation-duration: 8s;
                -o-animation-direction: normal;

                animation-name: ani4;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
                animation-duration: 8s;
                animation-direction: normal;
                border: 2px solid $color;
            }

            @-webkit-keyframes ani {
                0% {-webkit-transform: scale(0.75); opacity: 0}
                1% {-webkit-transform: scale(0.75); opacity: 0.8}
                95% {-webkit-transform: scale(1); opacity: 0.8;}
                100% {-webkit-transform: scale(1); opacity: 0;}
            }

            @-moz-keyframes ani{
                0% {-moz-transform: scale(0.75); opacity: 0}
                1% {-moz-transform: scale(0.75); opacity: 0.8}
                95% {-moz-transform: scale(1); opacity: 0.8;}
                100% {-moz-transform: scale(1); opacity: 0;}
            }

            @-ms-keyframes ani{
                0% {-ms-transform: scale(0.75); opacity: 0}
                1% {-ms-transform: scale(0.75); opacity: 0.8}
                95% {-ms-transform: scale(1); opacity: 0.8;}
                100% {-ms-transform: scale(1); opacity: 0;}
            }

            @-o-keyframes ani{
                0% {-o-transform: scale(0.75); opacity: 0}
                1% {-o-transform: scale(0.75); opacity: 0.8}
                95% {-o-transform: scale(1); opacity: 0.8;}
                100% {-o-transform: scale(1); opacity: 0;}
            }

            @keyframes ani {
                0% {transform: scale(0.75); opacity: 0}
                1% {transform: scale(0.75); opacity: 0.8}
                95% {transform: scale(1); opacity: 0.8;}
                100% {transform: scale(1); opacity: 0;}
            }

            @-webkit-keyframes ani2 {
                0% {-webkit-transform: scale(0.875); opacity: 0}
                1% {-webkit-transform: scale(0.875); opacity: 0.8}
                95% {-webkit-transform: scale(1); opacity: 0.8;}
                100% {-webkit-transform: scale(1); opacity: 0;}
            }


            @-moz-keyframes ani2{
               0% {-moz-transform: scale(0.875); opacity: 0}
                1% {-moz-transform: scale(0.875); opacity: 0.8}
                95% {-moz-transform: scale(1); opacity: 0.8;}
                100% {-moz-transform: scale(1); opacity: 0;}
            }

            @-ms-keyframes ani2{
                0% {-ms-transform: scale(0.875); opacity: 0}
                1% {-ms-transform: scale(0.875); opacity: 0.8}
                95% {-ms-transform: scale(1); opacity: 0.8;}
                100% {-ms-transform: scale(1); opacity: 0;}
            }

            @-o-keyframes ani2{
                0% {-o-transform: scale(0.875); opacity: 0}
                1% {-o-transform: scale(0.875); opacity: 0.8}
                95% {-o-transform: scale(1); opacity: 0.8;}
                100% {-o-transform: scale(1); opacity: 0;}
            }

            @keyframes ani2 {
                0% {transform: scale(0.875); opacity: 0}
                1% {transform: scale(0.875); opacity: 0.8}
                95% {transform: scale(1); opacity: 0.8;}
                100% {transform: scale(1); opacity: 0;}
            }

            @-webkit-keyframes ani3 {
                0% {-webkit-transform: scale(0.714); opacity: 0}
                1% {-webkit-transform: scale(0.714); opacity: 0.8}
                95% {-webkit-transform: scale(1); opacity: 0.8;}
                100% {-webkit-transform: scale(1); opacity: 0;}
            }

            @-moz-keyframes ani3{
                0% {-moz-transform: scale(0.714); opacity: 0}
                1% {-moz-transform: scale(0.714); opacity: 0.8}
                95% {-moz-transform: scale(1); opacity: 0.8;}
                100% {-moz-transform: scale(1); opacity: 0;}
            }

            @-ms-keyframes ani3{
                0% {-ms-transform: scale(0.714); opacity: 0}
                1% {-ms-transform: scale(0.714); opacity: 0.8}
                95% {-ms-transform: scale(1); opacity: 0.8;}
                100% {-ms-transform: scale(1); opacity: 0;}
            }

            @-o-keyframes ani3{
                0% {-o-transform: scale(0.714); opacity: 0}
                1% {-o-transform: scale(0.714); opacity: 0.8}
                95% {-o-transform: scale(1); opacity: 0.8;}
                100% {-o-transform: scale(1); opacity: 0;}
            }

            @keyframes ani3 {
                0% {-webkit-transform: scale(0.714); opacity: 0}
                1% {-webkit-transform: scale(0.714); opacity: 0.8}
                95% {-webkit-transform: scale(1); opacity: 0.8;}
                100% {-webkit-transform: scale(1); opacity: 0;}
            }


            @-webkit-keyframes ani4 {
                0% {-webkit-transform: scale(0.8); opacity: 0}
                1% {-webkit-transform: scale(0.8); opacity: 0.8}
                95% {-webkit-transform: scale(1); opacity: 0.8;}
                100% {-webkit-transform: scale(1); opacity: 0;}
            }

            @-moz-keyframes ani4{
                0% {-moz-transform: scale(0.8); opacity: 0}
                1% {-moz-transform: scale(0.8); opacity: 0.8}
                95% {-moz-transform: scale(1); opacity: 0.8;}
                100% {-moz-transform: scale(1); opacity: 0;}
            }

            @-ms-keyframes ani4{
                0% {-ms-transform: scale(0.8); opacity: 0}
                1% {-ms-transform: scale(0.8); opacity: 0.8}
                95% {-ms-transform: scale(1); opacity: 0.8;}
                100% {-ms-transform: scale(1); opacity: 0;}
            }

            @-o-keyframes ani4{
                0% {-o-transform: scale(0.8); opacity: 0}
                1% {-o-transform: scale(0.8); opacity: 0.8}
                95% {-o-transform: scale(1); opacity: 0.8;}
                100% {-o-transform: scale(1); opacity: 0;}
            }

            @keyframes ani4 {
                0% {transform: scale(0.8); opacity: 0}
                1% {transform: scale(0.8); opacity: 0.8}
                95% {transform: scale(1); opacity: 0.8;}
                100% {transform: scale(1); opacity: 0;}
            }";
        $style .= self::styleStat($color);
        $style .= "#cc-popup .cc-content span.cc-head{
                position:relative;
                font-family: arial, Helvetica, sans-serif;
                margin: 0px;
                font-size: 24px;
                text-align: center;
                padding: 50px 0 ;
                color: #566473;
                font-weight: normal;
                display:block;
            }

            #cc-popup .cc-content .cc-head .cc-bold{
                font-weight: bold;
            }

            #cc-popup span#cc-call{
                font-family: arial, Helvetica, sans-serif;
                font-size: 18px;
                color: #fff;
                border: 1px solid #b2b2b2;
                background-color: #33a94d;
                text-decoration: none;
                border-radius: 3px;
                padding: 10px 0;
                width:188px;
                display: inline-block;
                vertical-align:top;
                cursor:pointer;
            }

            #cc-popup span#cc-call1{
                font-family: arial, Helvetica, sans-serif;
                font-size: 18px;
                color: #fff;
                border: 1px solid #b2b2b2;
                background-color: #566473;
                text-decoration: none;
                border-radius: 3px;
                padding: 10px 0;
                width:188px;
                display: none;
                vertical-align:top;
                cursor:pointer;
            }

            #cc-popup span#cc-call:hover{
                background-color: $color;
            }


            #cc-popup input[type=\"text\"] {
                color:#566473;
                border-radius: 3px;
                padding: 10px;;
                font-size: 18px;
                border: 1px solid #b2b2b2;
                width:244px;
                line-height: inherit;
                letter-spacing: normal;
                word-spacing: normal;
                text-transform: none;
                text-indent: 0px;
                text-shadow: none;
                display: inline-block;
                text-align: start;
                box-sizing: border-box;
                vertical-align:top;
                position:relative;
                margin:0;
            }

            #cc-popup .cc-wrapper{
                text-align: center;
                width:100%;
                position:relative;
            }

            #cc-error{
                margin-left:122px;
                text-align:left;
                color:red;
                padding:10px;
                width: 440px;
                font-size: 12px;
            }

            #cc-popup .cc-footer{
                font-family: arial, Helvetica, sans-serif;
                font-size: 14px;
                text-align: right;
                color: #566473;
                padding-top:8px;
                padding-right: 41px;
                background-color:#fff;
                height:37px;
                position:relative;
            }
        </style>";

        $script = "
            var body = document.body;
            var html = document.documentElement;
            var height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );
            document.getElementById(\"cc-popup-shadow\").style.height=height;
        ";

        $html = '
        <div id="cc-phone-button-wrap">
            <div onclick="cPopupOpen()" id="cc-phone-button"></div>
            <div id="r4" class="ring4"></div>
            <div id="r3" class="ring3"></div>
            <div id="r2" class="ring2"></div>
            <div id="r1" class="ring"></div>
        </div>
        <div id="cc-popup-shadow"></div>
        <div id="cc-popup">
        <div class="cc-close" onclick="cPopupClose()"></div>
        <div class="cc-content">
            <span class="cc-head">Оставьте свой номер и мы перезвоним Вам<br> в течение <span class="cc-bold" id="cc-timer">30</span> <span class="cc-bold">секунд</span>! Засекайте!</span>
            <div class="cc-wrapper">
                <input id="cc-phone" type = "text" value="+7"> <span id="cc-call" onClick="cSendCall()" href="#">Жду звонка</span><span id="cc-call1" href="#">Жду звонка</span>
                <div id="cc-error"></div>
            </div>
        </div>
        <div class="cc-footer">
            Call-центр №1
        </div>
    </div>
    ';



        $style = trim(preg_replace('/\s\s+/', '', $style));
        $html = trim(preg_replace('/\s\s+/', '', $html));
        $script = trim(preg_replace('/\s\s+/', '', $script));

        $result = "
            function cPopupClose(){
                document.getElementById(\"cc-popup\").style.display=\"none\";
                document.getElementById(\"cc-popup-shadow\").style.display=\"none\";
                if(localStorage.hasOwnProperty('cc-call')==false){
                    localStorage.setItem('cc-call',1);
                }
            }
            function cPopupOpen(){
                document.getElementById(\"cc-popup\").style.display=\"block\";
                document.getElementById(\"cc-popup-shadow\").style.display=\"block\";
                var focusC =  document.getElementById(\"cc-phone\").value;
                document.getElementById(\"cc-phone\").focus();
                cSetEnd(document.getElementById(\"cc-phone\"));

            }

            function cSetEnd(txt) {
                if (txt.createTextRange) {
                    var FieldRange = txt.createTextRange();
                    FieldRange.moveStart(\"character\", txt.value.length);
                    FieldRange.collapse();
                    FieldRange.select();
                }else{
                    txt.focus();
                    var length = txt.value.length;
                    txt.setSelectionRange(length, length);
                }
            }


            function cSendCall(){
                document.getElementById(\"cc-error\").innerHTML=\"\";
                var phone =document.getElementById(\"cc-phone\").value;
                if(!/^\\+7[0-9]{10}$/.test(phone)){
                    document.getElementById(\"cc-error\").innerHTML=\"Неверный формат телефона: Телефон должен начинаться с +7 и содержать только цифры\";
                    return false;
                }
                document.getElementById(\"cc-call\").style.display = \"none\";
                document.getElementById(\"cc-call1\").style.display = \"inline-block\";
                setTimeout(cTimerDown,1000);
                var r = new XMLHttpRequest();
                r.open(\"GET\",\"".url('externcall')."?phone=\"+phone+\"&key=".$client->key."\", true);
                r.onreadystatechange = function () {
                    if (r.readyState != 4 || r.status != 200) return;
                };
                r.send();
            }

            function cTimerDown(){
                document.getElementById(\"cc-timer\").style.color = \"$color\";
                var timer = parseInt(document.getElementById(\"cc-timer\").innerHTML);
                document.getElementById(\"cc-timer\").innerHTML = timer-1;
                if(timer>1) setTimeout(cTimerDown,1000);
            }


            ;(function(){

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
                var idleWait = 1000 * 60;

                document.addEventListener('mousemove',noEventOpenCall);
                document.addEventListener('keydown',noEventOpenCall);
                document.addEventListener('scroll',noEventOpenCall);
                document.addEventListener('touchstart',noEventOpenCall);

                document.body.insertAdjacentHTML('beforeend','".$style.$html."');
                window.setTimeout(function(){
                    if(localStorage.hasOwnProperty('cc-call') && localStorage.getItem('cc-call')==1) return false;
                    cPopupOpen();
                }, ".$miliseconds.");
                ".$script.";
            })();";
        return $result = trim(preg_replace('/\s\s+/', '', $result));
    }




    public static function getSendBackForm($client)
    {
        $miliseconds = (int)Request::get('sec',90000);

        $color =  static::getColorScheme((int)Request::get('color',1));

        $style=" <style>";
        $style.= static::styleStat();
        $style.="#cc-popup .cc-content span.cc-head{
                position:relative;
                font-family: arial, Helvetica, sans-serif;
                margin: 0px;
                font-size: 20px;
                text-align: center;
                padding: 10px 0 ;
                color: #566473;
                font-weight: normal;
                display:block;
            }

            #cc-popup .cc-content .cc-head .cc-bold{
                font-weight: bold;
            }

            #cc-popup span#cc-call{
                font-family: arial, Helvetica, sans-serif;
                font-size: 16px;
                color: #fff;
                border: 1px solid #b2b2b2;
                background-color: #33a94d;
                text-decoration: none;
                border-radius: 3px;
                padding: 10px 0;
                width:188px;
                display: inline-block;
                cursor:pointer;
            }


            #cc-popup span#cc-call:hover{
                background-color: #009321;
            }

            #cc-popup .cc-row{
                font-size:16px;
                display:block;
                text-align:center;
                margin-bottom:10px;
                color: #566473;
            }


            #cc-popup input[type=\"text\"] {
                color:#566473;
                border-radius: 3px;
                padding: 10px;;
                font-size: 16px;
                border: 1px solid #b2b2b2;
                width:244px;
                line-height: inherit;
                letter-spacing: normal;
                word-spacing: normal;
                text-transform: none;
                text-indent: 0px;
                text-shadow: none;
                display: inline-block;
                text-align: start;
                box-sizing: border-box;
                vertical-align:top;
                position:relative;
                margin:0;
            }

            #cc-popup .cc-wrapper{
                text-align: center;
                width:100%;
                position:relative;
            }

            #cc-error{
                display:block;
                visibility:hidden;
                text-align:center;
                color:red;
                width: 440px;
                font-size: 12px;
                margin:0 auto;
            }

            #cc-popup .cc-footer{
                font-family: arial, Helvetica, sans-serif;
                font-size: 14px;
                text-align: right;
                color: #566473;
                padding-top:8px;
                padding-right: 41px;
                background-color:#fff;
                height:37px;
                position:relative;
            }
        </style>
       ";

        $script = "
            var body = document.body;
            var html = document.documentElement;
            var height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );
            $(\"#cc-popup-shadow\").css(\"height\",height);
        ";

        $html = '
        <div id="cc-phone-button-wrap">
            <div onclick="cPopupOpen()" id="cc-phone-button"></div>
        </div>
        <div id="cc-popup-shadow"></div>
        <div id="cc-popup">
        <div class="cc-close" onclick="cPopupClose()"></div>
        <div class="cc-content">
            <span class="cc-head"> Оставьте свой номер телефона, мы перезвоним Вам<br>завтра в удобное для Вас время</span>
            <div class="cc-wrapper">
                <div class="cc-row">
                    <div id="cc-error">Неверный формат телефона: Телефон должен начинаться с +7 и содержать только цифры</div>
                    <input id="cc-phone" type = "text" value="+7">
                </div>
                <div class="cc-row">
                    <span>Выберите время для обратного звонка.</span><br>
                    <select style="margin-top: 10px;" id="cc-time"><option value="1">9:00-12:00 (МСК)</option><option value="2">12:00-16:00 (МСК)</option><option value="3">16:00-19:00 (МСК)</option><option value="4">19:00-21:00 (МСК)</option></select>
                </div>
                <div class="cc-row">
                    <span id="cc-call" onclick="cSendBackForm()">Жду звонка</span>
                </div>
            </div>
        </div>
        <div class="cc-footer">
            Call-центр №1
        </div>
    </div>
    ';


        $style = trim(preg_replace('/\s\s+/', '', $style));
        $html = trim(preg_replace('/\s\s+/', '', $html));
        $script = trim(preg_replace('/\s\s+/', '', $script));

        $result = "
            function cPopupClose(){
                document.getElementById(\"cc-popup\").style.display=\"none\";
                document.getElementById(\"cc-popup-shadow\").style.display=\"none\";
                if(localStorage.hasOwnProperty('cc-call')==false){
                    localStorage.setItem('cc-call',1);
                }
            }
            function cPopupOpen(){

                document.getElementById(\"cc-popup\").style.display=\"block\";
                document.getElementById(\"cc-popup-shadow\").style.display=\"block\";
                var focusC =  document.getElementById(\"cc-phone\").value;
                document.getElementById(\"cc-phone\").focus();
                cSetEnd(document.getElementById(\"cc-phone\"));

            }

            function cSetEnd(txt) {
                if (txt.createTextRange) {
                    var FieldRange = txt.createTextRange();
                    FieldRange.moveStart(\"character\", txt.value.length);
                    FieldRange.collapse();
                    FieldRange.select();
                }else{
                    txt.focus();
                    var length = txt.value.length;
                    txt.setSelectionRange(length, length);
                }
            }


            function cSendBackForm(){
                document.getElementById(\"cc-error\").style.visibility=\"hidden\";
                var phone =document.getElementById(\"cc-phone\").value;
                var time  =document.getElementById(\"cc-time\").value;
                if(!/^\\+7[0-9]{10}$/.test(phone)){
                    document.getElementById(\"cc-error\").style.visibility=\"visible\";
                    return false;
                }
                document.getElementsByClassName(\"cc-content\")[0].innerHTML= \"Спасибо за обращение, нащи менеджеры свяжутся с вами\";
                document.getElementsByClassName(\"cc-content\")[0].style.lineHeight = \"259px\";
                document.getElementsByClassName(\"cc-content\")[0].style.fontSize = \"20px\";
                document.getElementsByClassName(\"cc-content\")[0].style.textAlign= \"center\";
                setTimeout(cTimerDown,1000);
                var r = new XMLHttpRequest();
                r.open(\"GET\",\"".url('formback')."?&key=".$client->key."&phone=\"+phone+\"&time=\"+time, true);
                r.onreadystatechange = function () {
                    if (r.readyState != 4 || r.status != 200) return;
                };
                r.send();
            }

            function cTimerDown(){
                document.getElementById(\"cc-timer\").style.color = \"$color\";
                var timer = parseInt(document.getElementById(\"cc-timer\").innerHTML);
                document.getElementById(\"cc-timer\").innerHTML = timer-1;
                if(timer>1) setTimeout(cTimerDown,1000);
            }
            ;(function(){
                document.body.insertAdjacentHTML('beforeend','".$style.$html."');
                window.setTimeout(function(){
                    if(localStorage.hasOwnProperty('cc-call') && localStorage.getItem('cc-call')==1) return false;
                    cPopupOpen();
                }, ".$miliseconds.");
                ".$script.";
            })();";
        return $result = trim(preg_replace('/\s\s+/', '', $result));
    }
}