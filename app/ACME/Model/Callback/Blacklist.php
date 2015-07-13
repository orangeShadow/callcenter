<?php namespace App\ACME\Model\Callback;;

use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model {

    protected $table="blacklist";

    protected $fillable=[
        'phone',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
