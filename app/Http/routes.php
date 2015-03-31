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

Route::get('/home',function(){
    redirect(url('/'));
});

Route::get('/', ['middleware'=>'auth',function(){
    if(Auth::user()->role()->first()->code=="client")
    {
        return  redirect(url('/claim'));
    }else
    {
       return  redirect(url('/project'));
    }
}]);


Route::resource('project','ProjectController');

Route::resource('claim','ClaimController');
Route::post('claim/statuschange',['middleware'=>'auth',function(){
    $id  = Request::get('id');
    $claim =App\Claim::findOrFail($id);
    $claim->status = Request::get('status');
    $claim->save();
    return redirect("claim/$id");
}]);



Route::resource('user','UserController');

Route::resource('property','PropertyController');



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
