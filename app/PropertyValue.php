<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{


    protected $propertyTitle = '';
    protected $table = 'property_values';

    public $fillable = ["property_id", "value", "element_id"];


    public function property()
    {
        return $this->belongsTo('App\Property');
    }

    public function getPropertyTitle()
    {
        return $this->propertyTitle;
    }

    public function setPropertyTitle($title)
    {
        $this->propertyTitle = $title;
    }

    public function scopePropertiesClaim($query,$model)
    {
        $function = new \ReflectionClass($model);
        $className  = $function->getShortName();
        $project_id = $model->project_id;

        $query->join('properties', function($join) use ($className,$project_id){
            $join->on('properties.id', '=', 'property_values.property_id')->where('properties.model_goal','=',$className)->where('properties.link_id','=',$project_id);
        });
        $query->get(['property_values.id']);
    }

}
