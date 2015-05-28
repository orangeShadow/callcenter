<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model {

    protected $fillable=[
        'project_id',
        'title',
        'email',
        'sort'
    ];

}
