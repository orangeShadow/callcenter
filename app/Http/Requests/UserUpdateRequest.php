<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request {

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
			'name'=>'required',
            'phone'     =>'required|regex:#^[-+()0-9]+$#',
            'email'     =>'email|required',
            'role'      =>'numeric|regex:#[^1]#',
            'password'  =>'min:6|confirmed',
		];
	}


    public function messages()
    {
        return [
            'phone.required'=> 'Введите Телефон',
            'phone.regex' => 'Неверный формат телефона',
            'name.required'=> 'Введите ФИО',
            'email.required' =>'Введите email, он будет логином пользователя',
            'password.confirmed'=>'Введите подтверждение пароля'
        ];
    }
}
