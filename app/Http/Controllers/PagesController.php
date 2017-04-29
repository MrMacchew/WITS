<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function users()
    {
    	return view('pages/users');
    }

    public function departments()
    {
    	return view('pages/departments');
    }
}
