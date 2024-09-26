<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Informasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return Inertia::render('Welcome');
    }
    public function informasi(){
        return Inertia::render('Home/Informasi',[
            'informasi'=> Informasi::find(1),
        ]);
    }
}
