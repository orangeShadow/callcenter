<?php namespace App\Http\Controllers\Callback;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\ACME\Model\Callback\Client;


class ClientController extends Controller {

    public function __construct()
    {
        $this->middleware('manager');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $clients=Client::paginate(20);
		return view('callback.client.index')->with(compact('clients'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $client = new Client();
        $client->key = $this->generateRandomString(12);
        return view('callback.client.create')->with(compact('client'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
     * @param $request
	 * @return Response
	 */
	public function store(\App\Http\Requests\Callback\ClientRequest $request)
	{
        $client = new Client($request->all());

        if($client->save()){
            flash()->success('Клиент Создан, Ключ: '.$client->key);
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
        $client = Client::findOrFail($id);
        return view('callback.client.show')->with(compact('client'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = Client::findOrFail($id);
        return view('callback.client.edit')->with(compact('client'));
	}

	/**
	 * Update the specified resource in storage.
	 *
     * @param  $request;
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,\App\Http\Requests\Callback\ClientRequest $request)
	{
        $client = Client::findOrFail($id);


        if($client->update($request->all())){
            flash()->success('Клиент изменен, Ключ: '.$client->key);
            return redirect('callback/client');
        }
        return \Redirect::back()->withInput($request);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    private function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
