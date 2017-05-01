<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        return view('pages/users');
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
