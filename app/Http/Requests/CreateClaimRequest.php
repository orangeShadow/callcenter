<?php namespace App\Http\Requests;

use     Auth;
use App\Http\Requests\Request;

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
            'phone'     =>'required',
            'text'      =>'required',
            'project_id' =>'required|numeric',
        ];
    }

}
