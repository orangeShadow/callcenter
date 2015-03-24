<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use \App\Project;
use Illuminate\Support\Facades\View;
use Request;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
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


        $projects = Project::search(Request::all())->get();

        return view('project.index')->with(compact('projects','fluid'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $project = new Project();
		return view('project.create',compact('project'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\CreateProjectRequest $request)
	{

        $request = $request->all();
        $request['manager_id'] = Auth::user()->id;
        Project::create($request);
        return redirect('project');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$project=Project::findOrFail($id);
        return view('project.show',compact('project'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $project=Project::findOrFail($id);
        return view('project.edit',compact('project'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Requests\CreateProjectRequest $request)
	{
        $request = $request->all();
        $project=Project::findOrFail($id);
        $request['update_by'] = Auth::user()->id;
        $project->update($request);
        return redirect("project/$id");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $project =Project::findOrFail($id);
        $project->delete();
        return redirect('/project');
	}

}
