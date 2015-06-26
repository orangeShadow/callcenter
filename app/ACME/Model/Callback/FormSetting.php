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
        'client_id','colors','top','sop_interval','swe_interval','time_work','yandex_cn','yandex_goal'
    ];

    public function client()
    {
       return $this->belongsTo('App\ACME\Model\Callback\Client','client_id','id');
    }


}
