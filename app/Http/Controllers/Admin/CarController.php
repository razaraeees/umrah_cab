<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(){
      
        return view ('admin.car.index');
    }

    public function create(){
      
        return view ('admin.car.create');
    }

    public function edit($id){
      
        return view('admin.car.edit', compact('id'));
    }
}
