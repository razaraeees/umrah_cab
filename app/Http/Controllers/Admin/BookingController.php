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

    public function edit($id)
    {
        return view('admin.booking.edit', ['id' => $id]);
    }

    public function print(Request $request)
    {
        $filters = [
            'search' => $request->get('search', ''),
            'dateFilter' => $request->get('dateFilter', ''),
            'startDate' => $request->get('startDate', ''),
            'endDate' => $request->get('endDate', ''),
        ];
        
        return view('admin.booking.print', compact('filters'));
    }
}
