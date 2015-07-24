<?php namespace App\Http\Requests\Callback;

use App\Http\Requests\Request;

class SettingsRequest extends Request {

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
			'color'=>'numeric',
            'top'=>'required|numeric',
            'sop_interval'=>'required|numeric',
            'swe_interval'=>'required|numeric',
            'page_count'=>'numeric',
            'visit_count'=>'numeric',
            'client_count_show'=>'numeric',
            'site_time'=>'numeric',
            'defaultPhone'
		];
	}

    public function messages()
    {
        return [
            'sop_interval.required'=> "Заполните поле".\Lang::get('client.sop_interval'),
            'swe_interval.required'=>"Заполните поле".\Lang::get('client.swe_interval'),
            'sop_interval.numeric'=>"Поле".\Lang::get('client.sop_interval')." должно быть числом",
            'swe_interval.numeric'=>"Поле".\Lang::get('client.sop_interval')." должно быть числом",

            'page_count.numeric'=>"Поле".\Lang::get('client.page_count')." должно быть числом",
            'visit_count.numeric'=>"Поле".\Lang::get('client.visit_count')." должно быть числом",
            'client_count_show.numeric'=>"Поле".\Lang::get('client.client_count_show')." должно быть числом",
            'site_time.numeric'=>"Поле".\Lang::get('client.site_time')." должно быть числом",

        ];
    }

}
