<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account.driver_index');
    }

    public function driverDetails($id)
    {
        return view('admin.account.driver_details', ['id' => $id ]);
    }
}
