<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Annonce;
use App\Models\Bien;
use App\Models\Voiture;
use App\Models\Emploi;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::count();
        $annonces = Annonce::all();
        $biens = Bien::all();
        $voitures = Voiture::all();
        $emplois = Emploi::all();
        $users = User::all();

        return view('dashboard.admin', compact('users', 'annonces', 'biens', 'voitures', 'emplois'));
    }
}
