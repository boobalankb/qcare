<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreCharityRequest extends Request
{
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
            'name'          => 'required|unique:charities',
            'description'   => 'required',
            'address'       => 'required',
            'state'         => 'required',
            'country'       => 'required',
            'zip'           => 'required',
            'latitude'      => 'required',
            'longitude'     => 'required',
            'phone'         => 'required',
            'email'         => 'required',
        ];
    }
}
