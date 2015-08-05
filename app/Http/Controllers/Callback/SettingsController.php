<?php namespace App\Http\Controllers\Callback;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ACME\Model\Callback\FormSetting as Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\Callback\SettingsRequest;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

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

        if(empty($settings->color)){
            $settings->colors = 1;
        }
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
            //flash()->success('Заданы настройки для сайта: '.$settings->client->title);
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
        $fields = $request->except(['audioFileA','audioFileB']);
        if($request->hasFile('audioFileA'))
        {
            preg_match_all('#\.([A-Za-z0-9]+)$#',$request->file('audioFileA')->getClientOriginalName(),$maches);
            $ext = $maches[1][0];
            $filePath = Auth::user()->id."_audioFileA.".$ext;
            $request->file('audioFileA')->move(public_path().'/audio/', $filePath);
            $fields['audioFileA'] ='/audio/'.$filePath;
            $audioId  = Auth::user()->id."_audioFileB";
            $mtt = new \App\ACME\Helpers\MttAPI();
            $res = $mtt->setCallBackPrompt($filePath);
            $settings->setAttribute('audioFileA','/audio/'.$filePath);
            $settings->setAttribute('audioIdA',$audioId);
        }

        if($request->hasFile('audioFileB'))
        {
            preg_match_all('#\.([A-Za-z0-9]+)$#',$request->file('audioFileB')->getClientOriginalName(),$maches);
            $ext = $maches[1][0];
            $audioId  = Auth::user()->id."_audioFileB.";
            $filePath = Auth::user()->id."_audioFileB.".$ext;
            $request->file('audioFileB')->move(public_path().'/audio/', $filePath);
            $fields['audioFileB'] ='/audio/'.$filePath;
            $audioId  = Auth::user()->id."_audioFileB";
            $mtt = new \App\ACME\Helpers\MttAPI();
            $res = $mtt->setCallBackPrompt($filePath);
            $settings->setAttribute('audioFileB','/audio/'.$filePath);
            $settings->setAttribute('audioIdB',$audioId);
        }

        if($request->has('delAudioA'))
        {
            unlink(public_path().$settings->audioFileA);
            $settings->setAttribute('audioFileA',null);
            $settings->setAttribute('audioIdA',null);
        }

        if($request->has('delAudioB'))
        {
            unlink(public_path().$settings->audioFileB);
            $settings->setAttribute('audioFileB',null);
            $settings->setAttribute('audioIdB',null);
        }


        if( $settings->update($fields) ){
            flash()->success('Заданы настройки для сайта: '.$settings->client->title);
            return redirect()->back();
        }
        return \Redirect::back()->withInput($request);
	}

}
