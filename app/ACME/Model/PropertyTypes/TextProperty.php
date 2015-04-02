<?php
namespace App\ACME\Model\PropertyTypes;

use App\PropertyValue;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Contracts\Validation\ValidationException;

class TextProperty extends PropertyValue{

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
}