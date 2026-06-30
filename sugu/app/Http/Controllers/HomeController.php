<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::all();
        $annonces = Annonce::with(['categorie', 'user'])->latest()->get();

        return view('home', compact('categories', 'annonces'));
    }
}
