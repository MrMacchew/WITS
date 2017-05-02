<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;

class PagesController extends Controller
{
    public function settings()
    {
    	return view('pages/settings');
    }

    public function inventory()
    {
    	return view('pages/inventory');
    }
    public function locations()
    {
    	return view('pages/locations');
    }

    public function departments()
    {
        return view('pages/departments');
    }

    public function users()
    {

        $users = User::with('roles', 'departments')->get();
        // foreach ($users as $user) {
        //     dump($user->roles->first());
        // }

        $data = [
            "users" => $users,
            "roles" => Role::all(),
        ];

        // dd(collect($data)->toArray());
        return view('pages/users', $data);
    }

    public function rolesPermissions()
    {

        $data = [
        "roles" => Role::all(),
        "permissions" => Permission::all()

        ];
        return view('pages/roles-permissions', $data);
    }

    public function reports()
    {
    	return view('pages/reports');
    }
}
