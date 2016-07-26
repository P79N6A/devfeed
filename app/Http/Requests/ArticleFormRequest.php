<?php

namespace Fedn\Http\Requests;

class ArticleFormRequest extends Request
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
            'id'    => 'exists:articles',
            'title' => 'required|max:255',
            'summary' => 'required',
            'content' => 'required',
            'is_link' => 'required|boolean',
            'status'  => 'required|in:draft,published',
            'categories' => 'required',
            'figure' => 'image'
        ];
    }
}
