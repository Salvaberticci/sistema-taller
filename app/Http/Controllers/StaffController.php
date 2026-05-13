<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    //
    public function index()
    {
        return view('modules.staff.index');
    }
}
