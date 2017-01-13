<?php

namespace App\ACME\Model\PropertyTypes;

use App\PropertyValue;

class SelectProperty extends PropertyValue {
    public $rules = ['value'=>'string','property_id'=>'required'];
    protected $values;

    public function __construct(array $attributes = array(),$propertyTitle = null,$values=null)
    {
        $this->propertyTitle = $propertyTitle;
        $this->values = $values;

        parent::__construct($attributes);
    }

    public function setValueAttribute($value)
    {

        if(is_array($this->values)) {
            $values = $this->values;
        } else {
            $values = $this->property->values;
        }

        $this->attributes['value'] = $values[$value];

    }

}