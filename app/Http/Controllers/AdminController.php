<?php

namespace App\Http\Controllers;

use App\IP;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function viewIPs()
    {
        $ips = IP::all();
        return view('admin.dashboard')->with('ips', $ips);
    }
}
