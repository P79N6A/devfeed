<?php

namespace Fedn\Http\Requests;

use Fedn\Http\Requests\Request;
use Auth;
use Illuminate\Http\JsonResponse;

class RoleFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(app()->environment('local')) {
            return true;
        }
        if(Auth::check()) {
            $user = Auth::getUser();
            return $user->hasRole('Admin');
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required|max:255'
        ];
    }

    public function forbiddenResponse()
    {
        if($this->ajax() || $this->wantsJson()) {
            return new JsonResponse(['message'=>'您无权进行此项操作'], 403);
        } else {
            return response('您无权进行此项操作', 403);
        }
    }
}
