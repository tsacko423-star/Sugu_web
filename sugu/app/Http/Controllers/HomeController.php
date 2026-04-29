<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Emploi;
use App\Models\Voiture;

class HomeController extends Controller
{
    public function index()
    {
        $biens = Bien::with('user')->get();
        $emplois = Emploi::with('user')->get();
        $voitures = Voiture::with('user')->get();

        return view('home', compact('biens', 'voitures', 'emplois'));
    }
}
