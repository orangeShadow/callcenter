<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TypicalDescription extends Model {

    /**
     * @var array
     */
    protected $fillable=[
        'project_id',
        'description',
        'sort'
    ];

}
