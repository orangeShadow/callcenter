<?php namespace App;

use Carbon\Carbon;
use Faker\Provider\tr_TR\DateTime;
use Illuminate\Database\Eloquent\Model;
use PhpSpec\Exception\Exception;

class Claim extends Model
{

    protected $fillable = [
        'name',
        'phone',
        'backcall_at',
        'text',
        'note',
        'project_id',
        'operator_id',
        'update_by',
        'status',
        'missed_call',
        'without_contacts',
        'type_request',
        'send_mail'
    ];

    //protected $dates = [];


    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }

    public function operator()
    {
        return $this->belongsTo('App\User', 'operator_id', 'id');
    }

    public function updateby()
    {
        return $this->belongsTo('App\User', 'update_by', 'id');
    }

    public function scopeClient($query, $request)
    {
        //$query->join('projects','claim.project_id','=','projects.id');
        if (!empty($request['created_at_from']) && !empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime($request['created_at_to']);
            $query->whereBetween('claims.created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        } elseif (!empty($request['created_at_from']) && empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime();
            $query->whereBetween('claims.created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        } elseif (empty($request['created_at_from']) && !empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_to']);
            $dtTo = new \DateTime('created_at_to');
            $query->whereBetween('claims.created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        }

        if (!empty($request['status'])) {
            $query->where('claims.status', $request['status']);
        }

        if (!empty($request['id'])) {
            $query->where('claims.id', (int)$request['id']);
        }

        if (!empty($request['name'])) {
            $query->where('claims.name', 'like', "%" . $request['name'] . "%");
        }

        if (!empty($request['phone'])) {
            $query->where('claims.phone', 'like', "%" . $request['phone'] . "%");
        }

        if (!empty($request['missed_call'])) {

            $query->where('claims.missed_call', '=', $request['missed_call']);
        }

        if (!empty($request['without_contacts'])) {
            $query->where('claims.without_contacts', '=', $request['without_contacts']);
        }


        $projects_id = \Auth::user()->projects->lists('id');
        $createdProjects = \Auth::user()->createProject->lists('id');
        if (!empty($request["project_id"]) && in_array($request["project_id"], array_merge($projects_id, $createdProjects))) {
            $query->where('claims.project_id', '=', (int)$request["project_id"]);
        } else {
            $query->whereIn('claims.project_id', array_merge($projects_id, $createdProjects));
        }


        /*
        $query->join('projects', function($join)
        {
            $join->on('claims.project_id', '=', 'projects.id')->where('projects.client_id','=',\Auth::user()->id);
        });
        */
        $query->orderBy('claims.id', 'desc')->get(["claims.*"]);
    }

    public function scopeApi($query, $request)
    {

        if (!empty($request['created_at_from']) && !empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime($request['created_at_to']);
            $query->whereBetween('claims.created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        } elseif (!empty($request['created_at_from']) && empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime();
            $query->whereBetween('claims.created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        } elseif (empty($request['created_at_from']) && !empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_to']);
            $dtTo = new \DateTime('created_at_to');
            $query->whereBetween('claims.created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        } else {
            $dt = new \DateTime();
            $query->whereBetween('claims.created_at', [$dt->format('Y-m-d 00:00:00'), $dt->format('Y-m-d 23:59:59')]);
        }


        if ( !empty($request['project_id']) ) {
            $query->where('claims.project_id',$request["project_id"]);
        } else {
            throw new \Exception('Не задан проект');
        }

        $query->orderBy('claims.id', 'desc')->get(["claims.*"]);
    }

    public function scopeSearch($query, $request)
    {
        if (!empty($request['created_at_from']) && !empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime($request['created_at_to']);
            $query->whereBetween('created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        } elseif (!empty($request['created_at_from']) && empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime();
            $query->whereBetween('created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        } elseif (empty($request['created_at_from']) && !empty($request['created_at_to'])) {
            $dtFrom = new \DateTime($request['created_at_to']);
            $dtTo = new \DateTime('created_at_to');
            $query->whereBetween('created_at', [$dtFrom->format('Y-m-d 00:00:00'), $dtTo->format('Y-m-d 23:59:59')]);
        }

        if (!empty($request['id'])) {
            $query->where('id', (int)$request['id']);
        }

        if (!empty($request['name'])) {
            $query->where('name', 'like', "%" . $request['name'] . "%");
        }

        if (!empty($request['phone'])) {
            $query->where('phone', 'like', "%" . $request['phone'] . "%");
        }


        if (!empty($request['missed_call'])) {

            $query->where('claims.missed_call', '=', $request['missed_call']);
        }

        if (!empty($request['without_contacts'])) {
            $query->where('claims.without_contacts', '=', $request['without_contacts']);
        }

        if (!empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        if (!empty($request['operator_id'])) {
            $query->where('operator_id', (int)$request['operator_id']);
        }

        if (!empty($request['project_id'])) {
            $query->where('project_id', (int)$request['project_id']);
        }


        return $query;
    }


    //public function monthly

    public function scopeDaily($query)
    {
        $dt = new \DateTime();
        $hour = $dt->format('G');
        $now = $dt->format('Y-m-d H:00:00');


        $query->whereRaw('claims.created_at between DATE_SUB("' . $now . '", INTERVAL 24 HOUR) and "' . $now . '"');
        $query->join('projects', function ($join) use ($hour) {
            $join->on('claims.project_id', '=', 'projects.id')
                ->where('projects.reports_type', '=', \DB::raw('daily'))
                ->where('projects.hour_start', '=', \DB::raw($hour));
        })->select('claims.*');

        return $query;
    }


    public function scopeWeekly($query)
    {
        $query->join('projects', function ($join) {
            $join->on('claims.project_id', '=', 'projects.id')->where('projects.reports_type', '=', \DB::raw('weekly'));
        })
            ->whereRaw('YEARWEEK(claims.created_at)=YEARWEEK(NOW())')
            ->select('claims.*');

        return $query;
    }

    public function scopeMonthly($query)
    {
        $dt = new \DateTime();
        $month = intval($dt->format('n'));
        $year = intval($dt->format('Y'));
        $target_year_month = null;
        if ($month == 1) {
            $target_year_month = ($year - 1) . '12';
        } else {
            $target_year_month = $year . ($month - 1 < 10 ? "0" . ($month - 1) : ($month - 1));
        }

        $query->Join('projects', function ($join) {
            $join->on('claims.project_id', '=', 'projects.id')->where('projects.reports_type', '=', \DB::raw('monthly'));
        })
            ->whereRaw('EXTRACT(YEAR_MONTH FROM claims.created_at)=' . $target_year_month)
            ->select('claims.*');

        return $query;
    }

    public function scopeMonth($query)
    {
        $dt = new \DateTime();
        $month = intval($dt->format('n'));
        $year = intval($dt->format('Y'));
        $target_year_month = null;
        if ($month == 1) {
            $target_year_month = ($year - 1) . '12';
        } else {
            $target_year_month = $year . ($month - 1 < 10 ? "0" . ($month - 1) : ($month - 1));
        }
        $query->whereRaw('EXTRACT(YEAR_MONTH FROM claims.created_at)=' . $target_year_month);

        return $query;
    }


    public function scopeCurMonth($query)
    {
        $dt = new \DateTime();

        $query->whereBetween("created_at", [$dt->format("Y-m-01 00:00:00"), $dt->format("Y-m-d 23:59:59")]);

        return $query;
    }

    public function scopeYesterday($query)
    {
        $dt = new Carbon();
        $dt = $dt->subDay(1);

        $query->whereBetween("created_at", [$dt->format("Y-m-d 00:00:00"), $dt->format("Y-m-d 23:59:59")]);

        return $query;
    }

    public function statusT()
    {
        return $this->belongsTo('App\StatusClaim', 'status', 'code');
    }

    public function typeR()
    {
        return $this->belongsTo('App\ClaimType', 'type_request', 'id');
    }


    public function getDestinations()
    {
        if (!empty($this->project_id)) {
            return \App\Destination::where('project_id', '=', $this->project_id)->orderBy('sort')->get(['title', 'email']);
        } else {
            return null;
        }

    }
}
