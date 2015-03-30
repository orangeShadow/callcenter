<?php
namespace App\ACME\Model\PropertyTypes;

use App\PropertyValue;
use Illuminate\Database\Eloquent\Model;

class TextProperty extends PropertyValue{

    public function __construct(array $attributes = array(),$propertyTitle = null)
    {
        $this->propertyTitle = $propertyTitle;
        parent::__construct($attributes);
    }

}