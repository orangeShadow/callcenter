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

function print_r_pre($res){
    echo "<pre>";
    print_r($res);
    echo "</pre>";
}


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

Route::post('user/{id}/projects','UserController@postProjects');
Route::delete('user/{id}/projects','UserController@deleteProjects');
Route::resource('user','UserController');

Route::resource('property','PropertyController');

Route::resource('destination','DestinationController');
Route::resource('typicalDescription','TypicalDescriptionController');

Route::resource('claimType','ClaimTypeController');

Route::get('api/claims/','ApiController@getClaims');
Route::get('api/claims/{project_id}','ApiController@getClaimsByProjectId');

/**
 * Форма в CRM
 **/
Route::get('formback',function(){

    $key = Request::input('key',null);

    if(is_null($key)) return response()->json(['error'=>1,'message'=>'Key not found'])->header('Access-Control-Allow-Origin', '*');

    $client = \App\ACME\Model\Callback\Client::where('key','=',$key)->first();

    $phone = trim(Request::input('phone'));
    $blacklists  = \App\ACME\Model\Callback\Blacklist::where('phone','=',$phone)->get()->count();
    if($blacklists>0) return response()->json(['error'=>1,'message'=>'You are on blacklist'])->header('Access-Control-Allow-Origin', '*');


    $time  = Request::input('time');
    $timeSelect = array(1=>"9:00-12:00",2=>"12:00-16:00",3=>"16:00-19:00",4=>"19:00-21:00");

    $result = new stdClass();
    $result->error = 0;

    $out = App\ACME\Helpers\CRMHelper::sendClaim(445,12,2,
                [
                    "comment"=>$timeSelect[$time],
                    "fio"=>$client->title,
                    "phone"=>$phone
                ]
            );

    if ($out!='0'){
        $result->id=$out;
        return response()->json($result)->header('Access-Control-Allow-Origin', '*');
    }else{
        $result->error= 1;
        return response()->json($result)->header('Access-Control-Allow-Origin', '*');
    }
});