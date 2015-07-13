<?php namespace App\Http\Controllers\Callback;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ACME\Model\Callback\Blacklist;
use Illuminate\Http\Request;

class BlacklistController extends Controller {

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
		$blacklist=Blacklist::paginate(50);
        return view('callback.blacklist.index')->with(compact('blacklist'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $phone = new Blacklist();
        return view('callback.blacklist.create')->with(compact('phone'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(\App\Http\Requests\Callback\BlacklistRequest $request)
	{
        $phone = new Blacklist($request->all());

        if($phone->save()){
            flash()->success('Номер добавлен в черный список: '.$phone->phone);
            return redirect('callback/blacklist');
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
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Blacklist::destroy($id);
        return redirect('/callback/blacklist');
	}

}
