<?php namespace App;

use App\Http\Requests;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Project extends Model {

    protected $fillable=[
        'title',
        'status',
        'backcall_dt',
        'text',
        'note',
        'client_id',
        'manager_id'
    ];


    public function scopeSearch($query,$request)
    {

        if(!empty($request['created_at_from']) && !empty($request['created_at_to']))
        {

            $dtFrom = new \DateTime($request['created_at_from']);
            $dtTo = new \DateTime($request['created_at_to']);
            $query->whereBetween('created_at',[$dtFrom->format('Y-m-d 00:00:00'),$dtTo->format('Y-m-d 23:59:59')]);
        }
        /*elseif()
        {

        }elseif()
        {

        }else
        {

        }*/


        if(!empty($request['id']))
        {
            $query->where('id',(int)$request['id']);
        }

        if(!empty($request['title']))
        {
            $query->where('title',$request['title']);
        }


        if(!empty($request['status']))
        {
            $query->where('status',$request['status']);
        }

        if(!empty($request['manager_id']))
        {
            $query->where('manager_id',(int)$request['manager_id']);
        }


        if(!empty($request['client_id']))
        {
            $query->where('client_id',(int)$request['client_id']);
        }

        return $query;

    }

    public function client()
    {
        return $this->belongsTo('App\User','client_id','id');
    }

    public function manager()
    {
        return $this->belongsTo('App\User','manager_id','id');
    }
}
