<?php namespace App\ACME\Model\Callback;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

	protected $fillable = [
        'title','href','key','sip','active'
    ];


    public $timestamps = true;

    protected $dates=['created_at','updated_at'];

    public function settings()
    {
        return $this->hasOne('App\ACME\Model\Callback\FormSetting','client_id','id');
    }
}