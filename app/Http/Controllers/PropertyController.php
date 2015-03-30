<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Property;
use App\PropertyValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Response;

class PropertyController extends Controller {

    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected  $propertiesType = [
                "text"=>'текстовое',
                "number"=>'числовое',
                "date"  =>'дата'
            ];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $model = \Request::get('model');
		if(empty($model))
        {
            return abort('404',\Lang::get('property.existModel'));
        }
        $link_id = \Request::get('link_id');
        if(empty($link_id))
        {
            return abort('404',\Lang::get('property.existLinkElement'));
        }
        $propties = Property::where('model_initiator','=',$model)->where('link_id','=',$link_id)->orderBy('sort')->get();
        $proptyList = [];
        foreach($propties as $property)
        {
            $property->type = $this->propertiesType[$property->type];
            array_push($proptyList,$property);
        }
        return Response::json($proptyList);
	}


    public function create(){
        $property = new Property();
        return view('project.propertyform')->with(compact('property'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        try{
            $request = \Request::all();
            $validator = \Validator::make($request,
                [
                    'title'=>'required',
                    'type'=>'required',
                    'model_goal'=>'required',
                    'model_initiator'=>'required',
                    'link_id'=>'required|numeric',
                    'sort'=>'required|numeric'
                ]);
            if($validator->fails()){
                return Response::json(['error'=>1,'errors'=>$validator->errors()],500);
            }
            //$property= Property::create($request);
            //$property->type = $this->propertiesType[$property->type];
            //return $property->toJson();
            return Response::json($request);
        }catch(Exception $e)
        {
            dd($e);
        }
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
        Property::destroy($id);
        PropertyValue::where('property_id','=',$id)->delete();
	}

}
