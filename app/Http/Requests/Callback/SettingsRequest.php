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
            'swe_interval'=>'required|numeric'
		];
	}

}
