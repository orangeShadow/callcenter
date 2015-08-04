<?php namespace App\ACME\Model\Callback;

use Illuminate\Database\Eloquent\Model;

class PhoneLog extends Model {

    protected $fillable = [
        'client_id','phone','call_id','ip','initiator'
    ];

    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo('App\ACME\Model\Callback\Client','client_id','id');
    }
}
