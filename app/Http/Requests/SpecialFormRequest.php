<?php

namespace Fedn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialFormRequest extends FormRequest
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
            'id'    => 'exists:specials',
            'title' => 'required|max:255',
            'desc' => 'required',
            'accept_email' => 'email',
            'user_id' => 'exists:users,id',
        ];
    }
}
