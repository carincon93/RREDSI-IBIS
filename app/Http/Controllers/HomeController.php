<?php

namespace App\Http\Controllers;

use App\Models\InstitucionEducativa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return Inertia::render('Home', [
            'institucionesEducativas' => InstitucionEducativa::select('id as value', 'nombre as label')->where('id', auth()->user()->institucion_educativa_id)->orderBy('nombre')->get()
        ]);
    }
}
