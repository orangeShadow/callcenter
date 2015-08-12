<?php namespace App\ACME\Model\Callback;

use Illuminate\Database\Eloquent\Model;

class FormSetting extends Model {

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'client_id';

    protected $fillable = [
        'client_id',
        'colors',
        'top',
        'sop_interval',
        'swe_interval',
        'time_work',
        'yandex_cn',
        'yandex_goal',
        'page_count',
        'client_count_show',
        'visit_count',
        'site_time',
        'phones',
        'textA',
        'textB',
        'audioFileA',
        'audioFileB',
        'audioIdA',
        'audioIdB',
        'defaultPhone',
        'record',
        'right',
        'color_code',
        'button_size'
    ];

    public function client()
    {
       return $this->belongsTo('App\ACME\Model\Callback\Client','client_id','id');
    }

    public function setRecordAttribute($value)
    {
        if(!empty($value)) $this->attributes["record"] = 1;
        else $this->attributes["record"] = 0;
    }


    public function setPageCountAttribute($value)
    {
        if(empty($value)) $this->attributes["page_count"] = null;
    }


    public function setClientCountShowAttribute($value)
    {
        if(empty($value)) $this->attributes["client_count_show"] = null;
    }


    public function setVisitCountAttribute($value)
    {
        if(empty($value)) $this->attributes["visit_count"] = null;
    }

    public function setSiteTimeAttribute($value)
    {
        if(empty($value)) $this->attributes["site_time"] = null;
    }

}
