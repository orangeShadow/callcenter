<?php namespace App\ACME\Model\Callback;

use Illuminate\Database\Eloquent\Model;

class PhoneLog extends Model {

    protected $fillable = [
        'client_id','phone'
    ];

}
