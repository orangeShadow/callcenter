<?php namespace App\Http\Controllers;

use App\ACME\Helpers\KodiResponse;
use App\Project;
use App\Claim;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller {

    public function getClaims(Request $request)
    {

        if(!$request->has('key')) abort('500','Key not found');

        $user = User::where('apikey','=',$request->input('key'))->first();

        if(is_null($user)) abort('500','User with this key not found');

        $projects = $user->projects;

        \Log::alert('Проекты',['projects'=>$projects->lists('id','title')]);
        //$createdProject = \Auth::user()->createProject->get();

        $projectClaims = array();

        $requestArray = $request->all();

        foreach($projects as $project)
        {
            $claims= [];

            $requestArray["project_id"] = $project->id;

            $claimCollection = Claim::api($requestArray)->get();

            foreach($claimCollection as $claim)
            {
                $claimEl["id"] = $claim->id;
                $claimEl["Имя"] = $claim->name;
                $claimEl["Дата создания"] = $claim->created_at->format('Y-m-d H:i:s');
                $claimEl["Проект"] = $project->title;
                $claimEl["Комментарий"] = $claim->text;
                $claimEl["Телефон"] = $claim->phone;
                $claimEl["Перезвонить"] = $claim->backcall_at;
                $claimEl["Статус"] = $claim->statusT->title;
                $claimEl["Тип Обращения"] = !empty($claim->typeR->title) ? $claim->typeR->title:'';
                foreach(\App\Property::showPropertyValue($claim) as $property){
                    $claimEl[$property["title"]] = $property['value'];
                }
                $claims[] = $claimEl;
            }
            if(empty($claims)) continue;
            $projectClaims[$project->title] = $claims;
        }



        if( !$request->has('type') ) {

            if(empty($projectClaims)) return response('Проектов не найдено.');
            return \Excel::create('Filename', function($excel) use($projectClaims) {

                // Set the title
                $excel->setTitle('Отчет');

                foreach($projectClaims as $key=>$claims)
                {
                    $title = substr(str_slug(htmlspecialchars($key)),0,strlen($key)>25? 25:strlen($key));
                    $excel->sheet($title,function($sheet) use ($claims) {
                       $sheet->fromArray($claims);
                    });
                }

            })->download('xlsx');

        } else {
            $response = new KodiResponse();
            return $response->createResponse($projectClaims,200);
        }
    }


    function  getClaimsByProjectId($project_id,Request $request) {
        if( !\Auth::user()->checkRole(['admin','manager']) )   abort('500','Key not found');

        $requestArray = $request->all();

        $requestArray["project_id"] = $project_id;

        $project = Project::find($project_id);

        $claimCollection = Claim::api($requestArray)->get();



        $claims = [];

        foreach($claimCollection as $claim)
        {
            $claimEl["id"] = $claim->id;
            $claimEl["Имя"] = $claim->name;
            $claimEl["Дата создания"] = $claim->created_at->format('Y-m-d H:i:s');
            $claimEl["Проект"] = $project->title;
            $claimEl["Комментарий"] = $claim->text;
            $claimEl["Телефон"] = $claim->phone;
            $claimEl["Перезвонить"] = $claim->backcall_at;
            $claimEl["Статус"] = $claim->statusT->title;
            $claimEl["Тип Обращения"] = !empty($claim->typeR->title) ? $claim->typeR->title:'';
            foreach(\App\Property::showPropertyValue($claim) as $property){
                $claimEl[$property["title"]] = $property['value'];
            }
            $claims[] = $claimEl;
        }

        $projectClaims[$project->title] = $claims;

        if(empty($claims)) return response('Список заявок пуст',500);

        return \Excel::create('Filename', function($excel) use($projectClaims) {

            // Set the title
            $excel->setTitle('Отчет');

            foreach($projectClaims as $key=>$claims)
            {
                $title = substr(str_slug(htmlspecialchars($key)),0,strlen($key)>25? 25:strlen($key));
                $excel->sheet($title,function($sheet) use ($claims) {
                    $sheet->fromArray($claims);
                });
            }

        })->download('xlsx');

    }
}
