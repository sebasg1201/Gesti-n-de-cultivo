<?php
namespace App\Http\Controllers;

use App\Models\TipoLicencia;

class HomeController extends Controller
{
    public function index()
    {
        $licencias = TipoLicencia::all();

        return view('index_welcome', compact('licencias'));
    }
}
