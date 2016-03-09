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
        //$projects = Project::whereClientId($user->id)->get();

        \Log::alert('Обращение к API',['user'=>$user->toArray(),'request'=>$request->all(),'project'=>$projects]);

        $projectClaims = array();



        foreach($projects as $project)
        {
            $claims= [];

            $claimCollection = Claim::where('project_id','=',$project->id);
            if($request->has('dts')){
                $dtsObj = new \DateTime($request->input('dts'));
                if(get_class($dtsObj)!=="DateTime") abor(500,'Wrong date format');
                $claimCollection= $claimCollection->where('created_at','>=',$dtsObj->format('Y-m-d H:i:s'));
            }

            if($request->has('dte')){
                $dteObj = new \DateTime($request->input('dte'));
                if(get_class($dteObj)!=="DateTime") abor(500,'Wrong date format');
                $claimCollection= $claimCollection->where('created_at','<=',$dteObj->format('Y-m-d H:i:s'));
            }


            $claimCollection  = $claimCollection->orderBy('created_at',"DESC")->get();
            foreach($claimCollection as $claim)
            {
                $claimEl["id"] = $claim->id;
                $claimEl["Проект"] = $project->title;
                $claimEl["Заголовок"] = $claim->title;
                $claimEl["Комментарий"] = $claim->text;
                $claimEl["Телефон"] = $claim->phone;
                $claimEl["Перезвонить"] = $claim->backcall_at;
                $claimEl["Дата создания"] = $claim->created_at->format('Y-m-d H:i:s');
                $claimEl["Статус"] = $claim->statusT->title;
                //$claimEl['properties'] = [];
                foreach(\App\Property::showPropertyValue($claim) as $property){
                    $claimEl[$property["title"]] = $property['value'];
                }
                $claims[] = $claimEl;
            }

            $projectClaims[$project->title] = $claims;
        }



        if(!$request->has('type')){

            return \Excel::create('Filename', function($excel) use($projectClaims) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the setters
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');

                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                foreach($projectClaims as $key=>$claims)
                {
                    $excel->sheet($key,function($sheet) use ($claims) {
                       $sheet->fromArray($claims);
                    });
                }

            })->download('xlsx');

            //return response($excel,200,['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
        }else{
            $response = new KodiResponse();
            return $response->createResponse($claims,200);
        }
    }

}
