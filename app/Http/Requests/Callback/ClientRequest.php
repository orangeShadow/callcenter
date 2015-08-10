<?php namespace App\Http\Requests\Callback;

use App\Http\Requests\Request;

class ClientRequest extends Request {

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
			'title'=>'required',
            'href'=>'required|url',
            'sip'=>'numeric',
            'active'=>'boolean'
		];
	}


    public function messages()
    {
        return [
            'href.url'=>'Полн ссылка на сайта должна быть формата http://example.com',
            'sip.required'=>'Внутренний номер обязателен для заполнения',
            'sip.numeric'=>'Внутренний номер может содержать только цифры',
            'active'=>'boolean'
        ];
    }
}
