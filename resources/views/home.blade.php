@extends('app')

@section('content')

    <style>
        .cc-select{
            position: relative;
        }
        .cc-select >ul{
            display: none;
            position: absolute;
            top:0;
            left:0;
            padding: 0;
            width:150px;
            z-index: 100000;
        }
        ul.cc-ul-select>li{
            background-color: #fff;
            width: 150px;
            display: inline-flex;
            list-style-type: none;
            padding:5px;
            border:1px solid #ccc;
            border-top:none;
        }

        ul.cc-ul-select>li:hover{
            background-color:#ddd;
        }

        ul.cc-ul-select:hover{
            display: block;
        }

         ul.cc-ul-select>li:nth-child(1){
            border-top:1px solid #ccc;
        }

        .cc-select > span{
            padding: 5px;
            min-width: 100px;
            display: inline-block;

            text-align: left;
            border:1px solid #ccc;
            cursor: pointer;
        }

    </style>


<div style="width:300px">
    Выберите время:
    <div class="cc-select">
        <span>10:00</span>
        <ul class="cc-ul-select">
            <li data-value="10:00">10:00</li>
            <li data-value="11:00">11:00</li>
            <li data-value="12:00">12:00</li>
        </ul>
    </div>
</div>

    <div style="width:300px">
        Выберите день:
        <div class="cc-select">
            <span>сегодня</span>
            <ul class="cc-ul-select">
                <li data-value="сегодня">сегодня</li>
                <li data-value="завтра">завтра</li>
                <li data-value="послезавтра">послезавтра</li>
            </ul>
        </div>
    </div>
    asdasd asd ashjd ahsjd askjhd kasjhdjaskhd kjasd jkashdk jashd kjahs kdjhaskj dhajs d

@endsection
@section('endbody')
    <script src="/externform?key={{$client->key}}"></script>
    <script type="text/javascript">
        /*var validNavigation = false;

        function wireUpEvents() {
            var dont_confirm_leave = 0;
            var leave_message = 'You sure you want to leave?'

            function goodbye(e) {
                if (!validNavigation) {
                    if (dont_confirm_leave !== 1) {
                        if (!e) e = window.event;
                        //e.cancelBubble is supported by IE - this will kill the bubbling process.
                        e.cancelBubble = true;
                        e.returnValue = leave_message;
                        //e.stopPropagation works in Firefox.
                        if (e.stopPropagation) {
                            e.stopPropagation();
                            e.preventDefault();
                        }
                        //return works for Chrome and Safari
                        return leave_message;
                    }
                }
            }
            window.onbeforeunload=goodbye;
        }
        wireUpEvents();
        */
    </script>
    <script>
        document.getElementsByTagName('body')[0].addEventListener('click',function(e){
            var el = e.target.parentElement;
            var close = true;
            while(el.parentElement != null)
            {
                if(el.getAttribute('class')=='cc-ul-select') {
                    close = false;
                    break;
                };
                el = el.parentElement;
            }

            if(close)
            {
                var uls = document.getElementsByClassName('cc-ul-select');
                Array.prototype.slice.call(uls).forEach(function(item){
                    item.style.display="none";
                });

            }
        });

        Object.keys(document.getElementsByClassName('cc-ul-select')).map(
            function(key){
                var ul = document.getElementsByClassName('cc-ul-select')[key];
                ul.previousElementSibling.addEventListener('click',function(e){
                    e.stopPropagation();
                    ul.style.display="block";
                });
                var children = document.getElementsByClassName('cc-ul-select')[key].childNodes;
                for(var k in children)
                {
                    if(children[k].tagName=="LI"){
                        children[k].addEventListener('click',function(event){
                            var value = event.target.getAttribute('data-value');
                            var span  = ul.previousElementSibling;
                            span.textContent=value;
                            ul.style.display = "none";
                        });
                    }
                }
            });
    </script>
@endsection