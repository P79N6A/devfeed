<?php

namespace Fedn\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Fedn\Http\Requests;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Role;

class RoleController extends Controller
{
    public function getRoles(){
        $roles = Role::with('users')->paginate(10);

        return view('backend.role',['roles'=>$roles]);
    }
}
