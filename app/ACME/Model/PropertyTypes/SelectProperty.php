<?php

namespace App\ACME\Model\PropertyTypes;

use App\PropertyValue;

class SelectProperty extends PropertyValue {
    public $rules = ['value'=>'string','property_id'=>'required'];

    public function __construct(array $attributes = array(),$propertyTitle = null)
    {
        $this->propertyTitle = $propertyTitle;
        parent::__construct($attributes);
    }

    public function setValueAttribute($value)
    {
        $v = Validator::make(['value'=>$value],['value'=>'required'],['value.required'=>"Поле {$this->propertyTitle} обязательно для заполнения"]);
        if($v->fails())
        {
            throw new ValidationException($v);
        }
        $this->attributes['value'] = $value;
    }

    public function getValueAttribute()
    {
        $values = $this->property->values;

        if( isset($values[$this->attributes['value']]) )
            return $this->property->values[$this->attributes['value']];
        else
            return 'Поля были удалены или изменены';
    }

}