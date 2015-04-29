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
    return "(function(){
            $(document).ready(function(){
                window.setTimeout(function(){
                    $('body').append('<style>#cPhoneCall{text-decoration: none;font-size: 16pt; padding: 7px;padding-bottom: 8px;background-color:#FF3404;color:#fff;}#cPhoneCall:hover{background-color: #BF4D32}</style><div id=\"callcenter-popup\" style=\"position:absolute;width:500px;height:500px; top:50%; left:50%; margin-left: -250px;margin-top:-250px;text-align: center;\"><a href=\"#\" onclick=\"cpopupClose()\" style=\"position:absolute;right:10px;top:10px;text-decoration:none;\">X</a><div style=\"border-radius:250px; width:100%;height:100%; background-color: #0EA2E2;padding-top:150px;\"><h1 style=\"color:#fff;\">Есть вопрос?</h1><p style=\"margin-top: 20px;\"><input style=\"font-size:16pt;padding:5px;border:none;width: 240px;\" placeholder=\"введите номер\" type=\"text\" id=\"cPhone\"><a onclick=\"sendCall()\" id=\"cPhoneCall\" href=\"#\" >позвоните мне</a></p><img style=\"margin-top:20px\" src=\"http://shop.goodline.ru/bitrix/templates/s1/i/logo.png\"></div></div><script>function cpopupClose(){document.getElementById(\"callcenter-popup\").style.display=\"none\";}function sendCall(){var phone =document.getElementById(\"cPhone\").value; var r = new XMLHttpRequest();r.open(\"GET\",\"".url('externcall')."?phone=\"+phone, true);r.onreadystatechange = function () {if (r.readyState != 4 || r.status != 200) return;alert(r.responseText);};  r.send();}</script>');
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
    /*
    $callerId = "101";
    $oSocket = fsockopen(env('Asterisk_host'), env('Asterisk_port'), $errnum, $errdesc,50) or die("Connection to host failed");

    fputs($oSocket, "Action: Login\r\n");
    fputs($oSocket, "Username: ".env('Asterisk_user')."\r\n");
    fputs($oSocket, "Secret: ".env('Asterisk_secret')."\r\n\r\n");


    fputs($oSocket, "Action: originate\r\n");
    fputs($oSocket, "Channel: ".env('Asterisk_channel')."\r\n");
    fputs($oSocket, "Timeout: ".env('Asterisk_timeout')."\r\n");
    fputs($oSocket, "CallerId: ".$callerId."\r\n");
    fputs($oSocket, "Exten: ".env('Asterisk_exten')."\r\n");
    fputs($oSocket, "Context: ".env('Asterisk_context')."\r\n");
    fputs($oSocket, "Priority: ".env('Asterisk_priority')."\r\n\r\n");
    fputs($oSocket, "Action: Logoff\r\n\r\n");

    sleep (1);
    fclose($oSocket);

    return '';
    */
    return response(Request::input('phone'))->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
});