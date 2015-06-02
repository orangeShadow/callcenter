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
Route::post('claim/statuschange','ClaimController@postStatuschange');

Route::resource('user','UserController');

Route::resource('property','PropertyController');

Route::resource('destination','DestinationController');
Route::resource('typicalDescription','typicalDescriptionController');



/**
 * Тестовая форма
 **/
Route::get('externform',function(){
    \Debugbar::disable();
    $dt = new DateTime();

    if((int)$dt->format('H')<9 || (int)$dt->format('H')>21){
        $result = App\ACME\Helpers\CallbackHelper::getSendBackForm();
        return response ($result)->header('Content-Type','text/javascript');
    }else{
        $result = App\ACME\Helpers\CallbackHelper::getCallBackForm();
        return response ($result)->header('Content-Type','text/javascript');
    }
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
        return response(Request::input('phone'))->header('Access-Control-Allow-Origin', 'all');
        //return response()->header('Access-Control-Allow-Origin', 'http://shop.goodline.ru');
    }else{
        return response('Не введен номер')->header('Access-Control-Allow-Origin', 'all');
    }
});


/**
 * Форма в CRM
 **/
Route::get('formback',function(){
    $time  = Request::input('time');

    $timeSelect = array(1=>"9:00-12:00",2=>"12:00-16:00",3=>"16:00-19:00",4=>"19:00-21:00");


    $object  = new stdClass();
    $object->Questions = array();

    $question = new stdClass();
    $question->questionID = 445;
    $question->questionType = 12;
    $question->questionDirection = 2;
    $question->questionComment =$timeSelect[$time];

    $object->Questions[] = $question;

    $object->countryId= 1;
    $object->statusId = 1;
    $object->abonTypeId  = 2;
    $object->username="bitrix-site";

    $object->contactData = array();

    $gPhone =  new stdClass();
    $gPhone->name = '372';
    $gPhone->id = '1';


    $phone =  new stdClass();
    $phone->name = Request::input('phone');
    $phone->id = '2';

    $object->contactData[] = $gPhone;
    $object->contactData[] = $phone;

    $post_q['query'] = json_encode($object);
    $post = http_build_query($post_q);
    $result = new stdClass();
    $result->error = 0;


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://crm.roumingu.net/system/ajax/zayavka.php');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);

    $out = curl_exec($curl);
    if ($out!='0'){
        $result->id=$out;
        echo json_encode($result);
    }else{
        $result->error= 1;
        echo json_encode($result);
    }
    return '';
});