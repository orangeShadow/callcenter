<?php namespace App;

use Carbon\Carbon;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model {

    protected $fillable=[
        'name',
        'phone',
        'backcall_at',
        'text',
        'note',
        'project_id',
        'operator_id',
        'update_by',
        'status'
    ];

    protected $dates = ['backcall_at'];

    public function setBackcallAtAttribute($date)
    {
        $this->attributes['backcall_at'] = Carbon::parse($date);
    }

    public function project()
    {
        return $this->belongsTo('App\Project','project_id','id');
    }

    public function operator()
    {
        return $this->belongsTo('App\User','operator_id','id');
    }

    public function updateby()
    {
        return $this->belongsTo('App\User','update_by','id');
    }

    public function scopeClient($query,$request)
    {
        //$query->join('projects','claim.project_id','=','projects.id');
        if(!empty($request['created_at_from']) && !empty($request['created_at_to']))
        {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime($request['created_at_to']);
            $query->whereBetween('claims.created_at',[$dtFrom->format('Y-m-d 00:00:00'),$dtTo->format('Y-m-d 23:59:59')]);
        }elseif(!empty($request['created_at_from']) && empty($request['created_at_to']))
        {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime();
            $query->whereBetween('claims.created_at',[$dtFrom->format('Y-m-d 00:00:00'),$dtTo->format('Y-m-d 23:59:59')]);
        }elseif(empty($request['created_at_from']) && !empty($request['created_at_to']))
        {
            $dtFrom = new \DateTime($request['created_at_to']);
            $dtTo = new \DateTime('created_at_to');
            $query->whereBetween('claims.created_at',[$dtFrom->format('Y-m-d 00:00:00'),$dtTo->format('Y-m-d 23:59:59')]);
        }

        if(!empty($request['status']))
        {
            $query->where('claims.status',$request['status']);
        }

        if(!empty($request['id']))
        {
            $query->where('id',(int)$request['id']);
        }


        $query->join('projects', function($join)
        {
            $join->on('claims.project_id', '=', 'projects.id')->where('projects.client_id','=',\Auth::user()->id);
        });
    }

    public function scopeSearch($query,$request)
    {
        if(!empty($request['created_at_from']) && !empty($request['created_at_to']))
        {

            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime($request['created_at_to']);
            $query->whereBetween('created_at',[$dtFrom->format('Y-m-d 00:00:00'),$dtTo->format('Y-m-d 23:59:59')]);
        }elseif(!empty($request['created_at_from']) && empty($request['created_at_to']))
        {
            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime();
            $query->whereBetween('created_at',[$dtFrom->format('Y-m-d 00:00:00'),$dtTo->format('Y-m-d 23:59:59')]);
        }elseif(empty($request['created_at_from']) && !empty($request['created_at_to']))
        {
            $dtFrom = new \DateTime($request['created_at_to']);
            $dtTo = new \DateTime('created_at_to');
            $query->whereBetween('created_at',[$dtFrom->format('Y-m-d 00:00:00'),$dtTo->format('Y-m-d 23:59:59')]);
        }

        if(!empty($request['id']))
        {
            $query->where('id',(int)$request['id']);
        }

        if(!empty($request['name']))
        {
            $query->where('name','like',"%".$request['name']."%");
        }

        if(!empty($request['phone']))
        {
            $query->where('phone','like',"%".$request['phone']."%");
        }


        if(!empty($request['status']))
        {
            $query->where('status',$request['status']);
        }

        if(!empty($request['operator_id']))
        {
            $query->where('operator_id',(int)$request['operator_id']);
        }

        if(!empty($request['project_id']))
        {
            $query->where('project_id',(int)$request['project_id']);
        }


        return $query;
    }

}
