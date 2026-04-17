<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bien;
use App\Models\Voiture;
use App\Models\Emploi;

class BienController extends Controller
{
    public function index()
    {
        $biens = Bien::all();
        $voitures = Voiture::all();
        $emplois = Emploi::all();

        return view('home', compact('biens', 'voitures', 'emplois'));
    }
}