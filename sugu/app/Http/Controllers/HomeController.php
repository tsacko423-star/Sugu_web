<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Emploi;
use App\Models\Voiture;
use App\Models\Categorie;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $biens = Bien::with('user')->get();
        $emplois = Emploi::with('user')->get();
        $voitures = Voiture::with('user')->get();
        $categories = Categorie::all(); // Assuming you have a Category model

        return view('home', compact('categories', 'biens', 'emplois', 'voitures'));
    }
}
