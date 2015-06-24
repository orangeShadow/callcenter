<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClaimTypeRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        return [
            'project_id'=>'required',
            'title'=>'required',
            'price'=>'numeric'
        ];
	}


    public function messages()
    {
        return [
            'project_id.required'=> 'Номер проекта обязателен',
            'title.required'=>'Поле Название обязательное',
            'price.numeric'=>'Поле Цена должно быть числовым'
        ];
    }
}
