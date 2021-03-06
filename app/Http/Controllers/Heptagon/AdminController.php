<?php

namespace App\Http\Controllers\Heptagon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('heptagon.admin.home');
    }
}
