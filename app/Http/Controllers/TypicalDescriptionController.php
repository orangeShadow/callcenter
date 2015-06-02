<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TypicalDescription;
use Illuminate\Http\Request;

class TypicalDescriptionController extends Controller {

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
            $destinations =TypicalDescription::where('project_id',$request->get('project_id'))->orderBy('sort','asc')->get();
            return response()->json($destinations);
        } else {
            return abort(500, 'Не указан проект');
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param $request
     * @return Response
     */
    public function store(Requests\TypicalDescriptionRequest $request)
    {
        $request = $request->all();
        $destination = TypicalDescription::create($request);
        return response()->json($destination);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        TypicalDescription::destroy($id);
    }

}
