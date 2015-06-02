<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TypicalDescriptionRequest extends Request {

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
            'description'=>'required'
        ];
	}


    public function messages()
    {
        return [
            'project_id.required'=> 'Номер проекта обязателен',
            'description.required'=>'Поле title обязательное'
        ];
    }
}
