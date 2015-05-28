<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class DestinationRequest extends Request {

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
            'email'     =>'email|required',
            'title'     =>'required'
        ];
    }


    public function messages()
    {
        return [
            'project_id.required'=> 'Номер проекта обязателен',
            'email.email'=>'Вы ввели неверный формат email',
            'email.required'=>'Поле email обязательное',
            'title.required'=>'Поле title обязательное'
        ];
    }
}
