<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('admin.booking.index');
    }

    public function create()
    {
        return view('admin.booking.create');
    }

    // public function edit($id)
    // {
    //     return view('admin.booking.edit');
    // }
}
