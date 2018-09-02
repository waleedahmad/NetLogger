<?php

namespace App\Http\Requests;

use App\Rules\IPAddress;
use Illuminate\Foundation\Http\FormRequest;

class FindIPAddressFormRequest extends FormRequest
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
            'ip_address' => [
                'required',
                new IPAddress(),
                'exists:ip,ip'
            ]
        ];
    }

    public function messages()
    {
        return [
            'ip_address.exists' => ':attribute does not exist in database.'
        ];
    }
}
