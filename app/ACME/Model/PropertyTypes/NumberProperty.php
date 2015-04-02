<?php
namespace App\ACME\Model\PropertyTypes;

use App\PropertyValue;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Carbon\Carbon;
class NumberProperty extends PropertyValue{

    //protected $dates = ['value'];
    public $rules = ['value'=>'numeric','property_id'=>'required'];

    public function __construct(array $attributes = array(),$propertyTitle = null)
    {
        $this->propertyTitle = $propertyTitle;
        parent::__construct($attributes);
    }

    public function setValueAttribute($value)
    {
        $v = Validator::make(['value'=>$value],['value'=>'numeric|required'],['value.numeric'=>"Поле {$this->propertyTitle} должно быть числовым",'value.required'=>"Поле {$this->propertyTitle} обязательно для заполнения"]);
        if($v->fails())
        {
            throw new ValidationException($v);
        }
        $this->attributes['value'] = $value;
    }
}