<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::get('/home',function(){
   return redirect('/');
});

Route::get('/',function(Request $request){
    if (Auth::guest())
    {
        if ($request::ajax())
        {
            return response('Unauthorized.', 401);
        }
        else
        {
            return redirect()->guest('auth/login');
        }
    }elseif(Auth::user()->role()->first()->code=="client")
    {
        return  redirect(url('/claim'));
    }else
    {
       return  redirect(url('/project'));
    }
});


Route::resource('project','ProjectController');

Route::resource('claim','ClaimController');
Route::post('claim/statuschange',function(Request $request){
    if (Auth::guest())
    {
        if ($request::ajax())
        {
            return response('Unauthorized.', 401);
        }
        else
        {
            return redirect()->guest('auth/login');
        }
    }

    $id  = Request::get('id');
    $claim =App\Claim::findOrFail($id);
    $claim->status = Request::get('status');
    $claim->note = Request::get('note');
    $claim->save();
    return redirect("claim/$id");

});


Route::resource('user','UserController');

Route::resource('property','PropertyController');

/**
 * Тестовая форма
 **/
Route::get('externform',function(){
    \Debugbar::disable();
    $style="
        <style>
            #ccPhoneCall
            {
                text-decoration: none;
                font-size: 16pt;
                padding: 7px;
                padding-bottom: 8px;
                background-color:#FF3404;
                color:#fff;
            }
            #ccPhoneCall:hover{
                background-color: #BF4D32
            }
            #ccPopup{
                position:absolute;
                width:500px;
                height:500px;
                top:50%;
                left:50%;
                margin-left: -250px;
                margin-top:-250px;
                text-align: center;
                padding:0;

            }
            #ccClose{
                position:absolute;
                right:10px;
                top:10px;
                text-decoration:none;
            }
            #ccContainer{
                border-radius:100%;
                width:100%;
                height:100%;
                background-color: #0EA2E2;
                vertical-align: middle;
                color:#fff;
            }
            #ccContainer .ccMiddle{
                padding-top: 150px;
            }
            #ccContainer p{
                margin-top: 20px;
            }
            #ccContainer input{
                color:#000;
            }
            #ccPhone{
                font-size:16pt;
                padding:5px;
                border:none;
                width: 240px;
            }

        </style>";
    $style = trim(preg_replace('/\s\s+/', '', $style));
    $script = "
        <script>
            function cpopupClose(){
                document.getElementById(\"ccPopup\").style.display=\"none\";
            }
            function sendCall(){
                var phone =document.getElementById(\"ccPhone\").value;
                var r = new XMLHttpRequest();
                r.open(\"GET\",\"".url('externcall')."?phone=\"+phone, true);
                r.onreadystatechange = function () {
                    if (r.readyState != 4 || r.status != 200) return;
                    alert(r.responseText);};  r.send();
            }
        </script>";
    $script = trim(preg_replace('/\s\s+/', '', $script));
    return "(function(){
            $(document).ready(function(){
                window.setTimeout(function(){
                    $('body').append('".$style."<div id=\"ccPopup\" style=\"\"><a id=\"ccClose\" href=\"#\" onclick=\"cpopupClose()\">X</a><div id=\"ccContainer\" ><div class=\"ccMiddle\"><h1>Есть вопрос?</h1><p><input placeholder=\"введите номер\" type=\"text\" id=\"ccPhone\"><a onclick=\"sendCall()\" id=\"ccPhoneCall\" href=\"#\" >позвоните мне</a></p><img style=\"margin-top:20px\" src=\"http://shop.goodline.ru/bitrix/templates/s1/i/logo.png\"></div></div></div>".$script."');
                }, 3000);
            });
    })()";
});

/**
 * Тестовая форма
 **/
Route::get('getform',function(){
    return view('home');
});

/**
 * Тестоввый звонок
 **/
Route::get('externcall',function(){
    \Debugbar::disable();
    $phone = Request::input('phone');
    if(!empty($phone))
    {
        $callerId = "101";
        $oSocket = fsockopen(env('Asterisk_host'), env('Asterisk_port'), $errnum, $errdesc,50) or die("Connection to host failed");

        fputs($oSocket, "Action: Login\r\n");
        fputs($oSocket, "Username: ".env('Asterisk_user')."\r\n");
        fputs($oSocket, "Secret: ".env('Asterisk_secret')."\r\n\r\n");


        fputs($oSocket, "Action: originate\r\n");
        fputs($oSocket, "Channel: ".env('Asterisk_channel')."\r\n");
        fputs($oSocket, "Timeout: ".env('Asterisk_timeout')."\r\n");
        fputs($oSocket, "CallerId: ".$callerId."\r\n");
        fputs($oSocket, "Exten: ".Request::input('phone')."\r\n");
        fputs($oSocket, "Context: ".env('Asterisk_context')."\r\n");
        fputs($oSocket, "Priority: ".env('Asterisk_priority')."\r\n\r\n");
        fputs($oSocket, "Action: Logoff\r\n\r\n");

        sleep (1);
        fclose($oSocket);
        return response(Request::input('phone'))->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
        //return response()->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
    }else{
        return response('Не введен номер')->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
    }
});