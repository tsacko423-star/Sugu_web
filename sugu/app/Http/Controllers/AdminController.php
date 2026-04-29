<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Annonce;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::count();
        $annonces = Annonce::all();

        return view('dashboard.user', compact('users', 'annonces'));
    }
}
