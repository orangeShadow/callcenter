<?php namespace App\Http\Controllers\Callback;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CallbackController extends Controller {


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
		return view('callback.dashboard.index');
	}

}
