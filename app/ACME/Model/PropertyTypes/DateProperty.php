<?php
namespace App\ACME\Model\PropertyTypes;

use App\PropertyValue;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Carbon\Carbon;
class DateProperty extends PropertyValue{

    //protected $dates = ['value'];
    public $rules = ['value'=>'date','property_id'=>'required'];

    public function __construct(array $attributes = array(),$propertyTitle = null)
    {
        $this->propertyTitle = $propertyTitle;
        parent::__construct($attributes);
    }

    public function setValueAttribute($date)
    {
        $v = Validator::make(['value'=>$date],['value'=>'date|required'],['value.date'=>"Поле {$this->propertyTitle} должно быть датой",'value.required'=>"Поле {$this->propertyTitle} обязательно для заполнения"]);
        if($v->fails())
        {
            throw new ValidationException($v);
        }
        $this->attributes['value'] = Carbon::parse($date);
    }


    public function getValueAttribute($date)
    {

        return Carbon::parse($this->attributes['value'])->format('d.m.Y');
    }



}