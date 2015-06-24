<?php namespace App\Http\Controllers;

use App\ClaimType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClaimTypeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        \Debugbar::disable();
    }

    /**
     * Display a listing of the resource.
     * @param $request
     * @return Response
     */
    public function index(Request $request)
    {

        if ($request->get('project_id',false)){
            $claimTypes =ClaimType::where('project_id',$request->get('project_id'))->orderBy('sort','asc')->get();
            return response()->json($claimTypes);
        } else {
            return abort(500, 'Не указан проект');
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param $request
     * @return Response
     */
    public function store(Requests\ClaimTypeRequest $request)
    {
        $request = $request->all();
        $claimType = ClaimType::create($request);
        return response()->json($claimType);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        ClaimType::destroy($id);
    }


}
