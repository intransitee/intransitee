<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('landingpage.app');
    }

    public function dashboard()
    {
        return view('admin.master.master')->nest('child', 'admin.home');
    }
}
