<?php namespace App\Http\Controllers;

use App\Claim;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;

class ClaimController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $fluid = true;
        $claims = Claim::search(Request::all())->get();
		return view('claim.index',compact('claims','fluid'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$claim = new Claim();
        return view('claim.create',compact('claim'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreateClaimRequest $request)
	{
        $request = $request->all();
        $request['operator_id'] = Auth::user()->id;
        $request['status']='N';
        Claim::create($request);
        return redirect('claim');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$claim  = Claim::findOrFail($id);
        return view('claim.show',compact('claim'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $claim = Claim::findOrFail($id);
        return view('claim.edit',compact('claim'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Requests\CreateClaimRequest $request)
	{
        $request = $request->all();
        $claim =Claim::findOrFail($id);
        $request['update_by'] = Auth::user()->id;
        $claim->update($request);
        return redirect("claim/$id");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $claim =Claim::findOrFail($id);
        $claim->delete();
        return redirect('/claim');
	}

}
