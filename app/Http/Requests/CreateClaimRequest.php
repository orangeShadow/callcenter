<?php namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;
use \Illuminate\Validation\Validator;

class CreateClaimRequest extends Request {

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
            'name'     =>'required',
            'phone'     =>'required|regex:#^[-+()0-9]+$#',
            'text'      =>'required',
            'project_id' =>'required|regex:#[^0]#',
            'backcall_at'=>'required'
        ];
    }


    public function messages()
    {
        return [
            'phone.regex' => 'Неверный формат телефона',
            'backcall_at.required'=>'Дата обратного звонка должно быть заполнено',
        ];
    }
}
