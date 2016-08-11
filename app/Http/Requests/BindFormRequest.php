<?php

namespace Fedn\Http\Requests;

class BindFormRequest extends Request
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
            'name' => 'required_with:register_button',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'confirm_password' => 'required_with:register_button|same:password'
        ];
    }
}
