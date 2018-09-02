<?php

namespace App\Http\Requests;

use App\Rules\IPAccessible;
use App\Rules\IPAddress;
use App\Rules\IPBelongToUser;
use Illuminate\Foundation\Http\FormRequest;

class IPAddressFormRequest extends FormRequest
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
                new IPAccessible(),
                new IPBelongToUser(),
                'unique:ip,ip'
            ],
            'email' => strlen($this->email) ? 'email' : ''
        ];
    }

    public function messages()
    {
        return [
            'ip_address.unique' => ':attribute already exists in database.'
        ];
    }
}
