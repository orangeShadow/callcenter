<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model {



    protected $propertyTitle = '';
	protected $table= 'property_values';

    public $fillable = ["property_id","value","element_id"];


    public function getPropertyTitle(){
        return $this->propertyTitle;
    }

}
