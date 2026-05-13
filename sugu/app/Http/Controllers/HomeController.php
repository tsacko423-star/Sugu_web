<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Categorie::orderBy('name')->get();
        $annonces = Annonce::with('categorie')
            ->orderByDesc('created_at')
            ->get();

        return view('home', compact('categories', 'annonces'));
    }
}
