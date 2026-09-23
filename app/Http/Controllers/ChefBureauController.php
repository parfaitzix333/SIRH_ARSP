<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefBureauController extends Controller
{
    public function profile_cb1()
    {
        $user = Auth ::user();
        return view('cb.profile_cb1', compact('user'));
    }
    public function profile_cb2()
    {
        $user = Auth ::user();
        return view('cb.profile_cb2', compact('user'));
    }
    public function profile_cb3()
    {
        $user = Auth ::user();
        return view('cb.profile_cb3', compact('user'));
    }
}
