<?php

namespace Fedn\Http\Controllers\Admin;

//use Illuminate\Http\Request;

use Fedn\Http\Requests\RoleFormRequest;
use Fedn\Http\Controllers\Controller;
use Fedn\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function getRoles(){
        $roles = Role::with('users')->paginate(10);

        return view('backend.role',['roles'=>$roles]);
    }

    public function postSave(RoleFormRequest $req) {

        $role = Role::findOrNew($req->get('id', 0));

        $role->title = $req->get('title');
        $role->description = $req->get('description');
        $role->save();

        return (new JsonResponse($role));
    }

    public function postDelete(Role $role) {

        if(count($role->users) > 0) {
            return redirect('admin/roles')->with('message', ['type'=>'danger', 'text'=>"角色 $role->title 下还有用户,请先将用户从角色移除,再删除角色。"]);
        }

        if($role->is_system) {
            return redirect('admin/roles')->with('message',
                ['type' => 'danger', 'text' => "$role->title 是系统角色，不能删除。"]);
        }

        $role->delete();

        return redirect('admin/roles')->with('message', ['type'=>'success', 'text'=>"角色 $role->title 已成功删除。"]);
    }
}
