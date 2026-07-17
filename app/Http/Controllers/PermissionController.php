<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        $pages = Pages::all();

        $permissions = Permissions::orderBy('role_id', 'ASC')->get();

        return view('permissions.permission_view', compact('roles', 'pages', 'permissions'));
    }//index

    public function store(Request $request)
    {
        $role_id = $request->input('cmb_role');
        $page_id = $request->input('cmb_page');
        $can_create = $request->has('chk_create') ? 1 : 0;
        $can_edit = $request->has('chk_edit') ? 1 : 0;
        $can_view = $request->has('chk_view') ? 1 : 0;
        $can_delete = $request->has('chk_delete') ? 1 : 0;

        Permissions::create([
            'role_id' => $role_id,
            'page_id' => $page_id,
            'can_create' => $can_create,
            'can_edit' => $can_edit,
            'can_view' => $can_view,
            'can_delete' => $can_delete,
        ]);

        return redirect()->route('permission.index');
    }//store

    public function getOnePermission(Request $request)
    {
        $permission_id = $request->input('permission_id');

        $permission = Permissions::find($permission_id);

        return response()->json($permission);
    }
}//class
