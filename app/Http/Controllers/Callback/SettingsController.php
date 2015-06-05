<?php namespace App\Http\Controllers\Callback;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ACME\Model\Callback\FormSetting as Settings;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\Callback\SettingsRequest;

class SettingsController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 *
     * @param $id - client_id
	 * @return Response
	 */
	public function create()
	{
        $id = \Request::input('id');
        if(empty($id)) throw new HttpException(404,'Не указан сайт клиента');
		$settings = new Settings();
        $settings->client_id = $id;
        return view('callback.settings.create')->with(compact('settings'));

	}

    /**
     * Store a newly created resource in storage.
     *
     * @param SettingsRequest $request
     * @return Response
     */
	public function store(SettingsRequest $request)
	{
        $settings = new Settings($request->all());

        if($settings->save()){
            flash()->success('Заданы настройки для сайта: '.$settings->client->title);
            return redirect('callback/client');
        }
        return \Redirect::back()->withInput($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id client_id
	 * @return Response
	 */
	public function edit($id)
	{
        $settings = Settings::find($id);
        if(is_null($settings)){

            return Redirect::to('/callback/settings/create?id='.$id);
        }
        return view('callback.settings.edit')->with(compact('settings'));
	}

	/**
	 * Update the specified resource in storage.
	 *
     * @param $request;
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,SettingsRequest $request)
	{
        $settings = Settings::findOrFail($id);
        //$fields = $request->except(['client_id']);
        if( $settings->update($request->all()) ){
            flash()->success('Заданы настройки для сайта: '.$settings->client->title);
            return redirect('callback/client');
        }
        return \Redirect::back()->withInput($request);
	}

}
