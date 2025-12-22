<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteFaresController extends Controller
{
    public function index()
    {
        return view('admin.routefare.index');
    }

    public function create()
    {
        return view('admin.routefare.create');
    }

    public function edit($id)
    {
        return view('admin.routefare.edit', ['id' => $id]);
    }
}
