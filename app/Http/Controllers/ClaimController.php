<?php namespace App\Http\Controllers;

use App\Claim;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;

//use App\Events\ClaimCreate;

use App\Property;
use App\ACME\Model\PropertyTypes;
use Auth;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Support;
use Request;
use App\City;

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
        if(Auth::user()->checkRole('client')){
            $claims = Claim::client(Request::all())->orderBy('created_at','desc')->paginate(50);
        }else{
            $claims = Claim::search(Request::all())->orderBy('created_at','desc')->paginate(50);
        }

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
        $properties = [];

        if(Request::get('project_id'))
        {
            $claim->project_id = (int)Request::get('project_id');
            $properties  = Property::getPropertyByModel($claim);

            $properties  = array_filter($properties,function($item){
                if($item->active==0) return false;
                return true;
            });

            $cities = City::where("country_id",'=',3159)->get()->lists('name');
        }else{
            abort(404);
        }
        return view('claim.create',compact('claim','properties','cities'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreateClaimRequest $request)
	{
        try{
            $destinations = $request->get('destination');

            $request = $request->except('destination');
            $request['operator_id'] = Auth::user()->id;
            $request['status']='N';

            $claim = new Claim($request);
            $propertyList = array();
            $errors =new Support\MessageBag();
            if(!empty($request["property"]))
            {
                $properties  = Property::getPropertyByModel($claim);

                $properties  = array_filter($properties,function($item){
                    if($item->active==0) return false;
                    return true;
                });

                foreach($properties as $property)
                {
                    try{
                        if(isset($request["property"][$property->id]))
                        {
                            $attributes = [
                                'value'=>$request["property"][$property->id],
                                'property_id'=>$property->id
                            ];
                            if($property->type=='date')
                            {
                                $pr = new PropertyTypes\DateProperty($attributes,$property->title);
                            }elseif($property->type=='number'){
                                $pr = new PropertyTypes\NumberProperty($attributes,$property->title);
                            } elseif($property->type=='select'){
                                $pr = new PropertyTypes\SelectProperty($attributes,$property->title,$property->values);
                            }
                            else{
                                $pr = new PropertyTypes\TextProperty();
                                $pr->value = $request["property"][$property->id];
                                $pr->property_id = $property->id;
                            }
                        }
                        $propertyList[] = $pr;
                    }catch(ValidationException $e){
                        $errors->merge($e->errors());
                    }
                }
            }
            if($errors->count()>0)
            {
                return \Redirect::back()->withInput($request)->withErrors($errors);
            }

            \Log::info("Создагие заявки",$request);


            $claim->save($request);

            foreach($propertyList as $pr){
                $pr->element_id = $claim->id;
                $pr->save();
            }

            flash()->success('Обращение Создано, № '.$claim->id);
            \Event::fire(new  \App\Events\ClaimCreate($claim,$destinations));

            return redirect('project');
        }catch(\Exception $e)
        {
            \Log::error($e);
            print_r_pre($e);
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
        try
        {
            $claim  = Claim::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            abort(404);
        }

        $projects_id = \Auth::user()->projects->lists('id');
        $createdProjects = \Auth::user()->createProject->lists('id');

        if(Auth::user()->checkRole('client') && !in_array($claim->project_id,array_merge($projects_id,$createdProjects)) ) abort(404);

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
        try
        {
            $claim  = Claim::findOrFail($id);
        }
        catch (ModelNotFoundException $e)
        {
            abort(404);
        }

        $properties  = Property::getPropertyByModel($claim);

        $propertiesValue= \App\Property::showPropertyValue($claim);

        foreach($properties as $property)
        {
            if(!empty($propertiesValue[$property->id]["value"]))
                $property->value = $propertiesValue[$property->id]["value"];
            else
                $property->value = '';
        }

        $cities = City::where("country_id",'=',3159)->get()->lists('name');

        return view('claim.edit',compact('claim','properties','cities'));
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
        $propertyList = array();
        $errors =new Support\MessageBag();
        if(isset($request["property"]))
        {
            $properties  = Property::getPropertyByModel($claim);

            foreach($properties as $property)
            {
                try{
                    //if(isset($request["property"][$property->id]))
                    //{
                    $attributes = [
                        'value'=>$request["property"][$property->id],
                        'property_id'=>$property->id,
                        'element_id'=>$claim->id
                    ];

                    if($property->type=='date')
                    {
                        $pr = PropertyTypes\DateProperty::where('property_id',$property->id)->where('element_id',$claim->id)->first();
                        //$pr->setPropertyTitle($property->title);
                        if(empty($pr))
                        {
                            $pr = new PropertyTypes\DateProperty($attributes,$property->title);
                        }else{
                            $pr->value = $attributes["value"];
                        }
                    }elseif($property->type=='number'){
                        $pr = PropertyTypes\NumberProperty::where('property_id',$property->id)->where('element_id',$claim->id)->first();
                        //$pr->setPropertyTitle($property->title);
                        if(empty($pr))
                        {
                            $pr = new PropertyTypes\NumberProperty($attributes,$property->title);
                        }else{
                            $pr->value = $attributes["value"];
                        }
                    }
                    else{
                        $pr = PropertyTypes\TextProperty::where('property_id',$property->id)->where('element_id',$claim->id)->first();
                        //$pr->setPropertyTitle($property->title);
                        if(empty($pr))
                        {
                            $pr = new PropertyTypes\TextProperty($attributes,$property->title);
                        }else{
                            $pr->value = $attributes["value"];
                        }
                    }
                    //}
                    $propertyList[] = $pr;
                }catch(ValidationException $e){
                    $errors->merge($e->errors());
                }
            }
        }
        if($errors->count()>0)
        {
            return \Redirect::back()->withInput($request)->withErrors($errors);
        }
        $claim->update($request);
        foreach($propertyList as $pr){
            $pr->save();
        }
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

        /*
        $claim =Claim::findOrFail($id);

        $propertyIDs = PropertyValue::propertiesClaim($claim)->get();
        foreach($propertyIDs as $prop)
        {
            $prop->delete();
        }



        $claim->delete();

        return redirect('/claim');
        */
	}


    /**
     * @param Request $request
     * @return Response
     */
    public function postStatuschange(Request $request)
    {
        if (Auth::guest())
        {
            if ($request::ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect()->guest('auth/login');
            }
        }

        $id  = Request::get('id');
        $claim =Claim::findOrFail($id);
        $claim->status = Request::get('status');
        $claim->note = Request::get('note');
        $claim->save();
        return redirect("claim/$id");
    }
}
