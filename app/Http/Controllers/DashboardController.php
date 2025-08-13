<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function mahasiswa()
    {
        return view('mahasiswa.dashboard');
    }

}
