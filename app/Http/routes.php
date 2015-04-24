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

    return "(function(){
            $(document).ready(function(){
                $('body').append('<div style=\"position:absolute;width:500px;height:500px; top:50%; left:50%; margin-left: -250px;margin-top:-250px;background-color: orangered;\"><h1>Hallo</h1></div>');
            });
    })()";
});

/**
 * Тестоввый звонок
 **/
Route::get('externcall',function(){
    $errnum = null;
    $errdesc = null;
    $callerId = "79094342294";
    $oSocket = fsockopen(env('Asterisk_host'), env('Asterisk_port'), $errnum, $errdesc,50) or die("Connection to host failed");

    fputs($oSocket, "Action: login\r\n");
    fputs($oSocket, "Username: ".env('Asterisk_user')."\r\n");
    fputs($oSocket, "Secret: ".env('Asterisk_secret')."\r\n");
    fputs($oSocket, "Events: off\r\n");
    fputs($oSocket, "Action: originate\r\n");
    fputs($oSocket, "Channel: ".env('Asterisk_channel')."\r\n");
    fputs($oSocket, "Timeout: ".env('Asterisk_timeout')."\r\n");
    fputs($oSocket, "CallerId: ".$callerId."\r\n");
    fputs($oSocket, "Exten: ".env('Asterisk_exten')."\r\n");
    fputs($oSocket, "Context: ".env('Asterisk_context')."\r\n");
    fputs($oSocket, "Priority: ".env('Asterisk_priority')."\r\n\r\n");
    fputs($oSocket, "Action: Logon\r\n\r\n");
    sleep (1);
    fclose($oSocket);

    xdebug_var_dump($errnum);
    xdebug_var_dump($errdesc);
    return '';
});