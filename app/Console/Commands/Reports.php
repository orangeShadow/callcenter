<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Project;
use App\Claim;
use App\Property;


class Reports extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'callcenter:reports';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send weekly report to clients';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $projects = [];

        \Log::info('Log reports console Type:'.$this->argument('type'));

        if($this->argument('type')=="daily")
        {
            foreach(Claim::daily()->get() as $claim)
            {
                $projects[$claim->project_id][] = $claim;
            }
        }

        if($this->argument('type')=="weekly")
        {
            foreach(Claim::weekly()->get() as $claim)
            {
                $projects[$claim->project_id][] = $claim;
            }
        }

        if($this->argument('type')=="monthly")
        {
            foreach(Claim::monthly()->get() as $claim)
            {
                $projects[$claim->project_id][] = $claim;
            }
        }

        \Log::info('Log reports console $projects:'.json_encode($projects));

        $this->drawTable($projects);

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
            ['type',InputArgument::REQUIRED,'Type reports [monthly,weekly,daily]']
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			//['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

    private function drawTable($projects)
    {
        foreach($projects as $key=>$claims)
        {
            $project = Project::find($key);

            $styleTd = 'style="border:1px solid #000;"';

            $table= '<table cellpadding="2" cellspacing="0" style="margin: 0;  width:100%;">';
            $table.= "<tr><td $styleTd>id</td><td $styleTd>Дата</td><td $styleTd>Клиент</td><td $styleTd>Контактный телефон</td><td $styleTd>Описание</td><td $styleTd>Дата обратного звонка</td><td $styleTd>Статус</td>";

            $propertiesPR = Property::where('model_initiator','=','project')->where('link_id','=',$key)->orderBy('sort')->get();
            foreach ($propertiesPR as $property) {
                $table.="<td $styleTd>".$property->title."</td>";
            }
            $table.= "</tr>";

            foreach($claims as $claim)
            {
                $table.="<tr>";
                $table.="<td $styleTd>$claim->id</td>";
                $table.="<td $styleTd>".$claim->created_at->format('d.m.Y H:i')."</td>";
                $table.="<td $styleTd>$claim->name</td>";
                $table.="<td $styleTd>$claim->phone</td>";
                $table.="<td $styleTd>$claim->text</td>";
                $table.="<td $styleTd>$claim->backcall_at</td>";
                if(!empty($claim->statusT->title)){
                    $table.="<td $styleTd>".$claim->statusT->title."</td>";
                }else{
                    $table.="<td $styleTd>$claim->status</td>";
                }


                $propertiesByTitle =[];
                $properties = \App\Property::showPropertyValue($claim);
                foreach($properties as $prop)
                {
                    $propertiesByTitle[$prop["title"]] = $prop["value"];
                }



                foreach($propertiesPR as $property)
                {
                    if(!empty($propertiesByTitle[$property->title]))
                    {
                        $table.="<td $styleTd>".$propertiesByTitle[$property->title]."</td>";
                    }else{
                        $table.="<td $styleTd></td>";
                    }

                }

                $table.="</tr>";
            }

            $table.= "</table>";

            $title = "Отчет за неделю: ".$project->title;

            \Mail::send('emails.reports',compact('table','title'), function($message) use ($project)
            {
                $emails = [];
                $emails[] = $project->client->email;
                if(!empty($project->client->send_email)){
                    $emailsSplit  = explode(",",$project->client->send_email);
                    foreach($emailsSplit as $item)
                    {
                        $emails[] = trim($item);
                    }
                }
                $message->to($emails, 'Callcenter №1')->subject('Круглосуточный call-центр №1');
            });

        }
    }
}
