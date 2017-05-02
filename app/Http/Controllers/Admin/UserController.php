<?php

namespace Fedn\Http\Controllers\Admin;

use Fedn\Models\User;
use Illuminate\Http\Request;

use Fedn\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUsers() {
        return view('backend.user');
    }

    public function getUsersApi() {
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    public function postSaveUserApi(Request $request) {
        $data = $request->only(['id', 'roles']);

        $user = User::find($data['id']);
        if($user) {
            return $user->roles()->sync($data['roles']);
        } else {
            return false;
        }
    }
}
