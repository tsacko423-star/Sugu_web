<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAnnonces = Annonce::count();
        $totalRevenue = Annonce::sum('prix');
        $totalCategories = Categorie::count();

        $recentAnnonces = Annonce::with(['user', 'categorie'])
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        $recentActivities = collect([
            (object)[
                'type' => 'new-user',
                'icon' => 'person-plus-fill',
                'title' => 'Nouvel utilisateur',
                'description' => 'Un nouvel utilisateur vient de s’inscrire.',
                'created_at' => now()->subMinutes(5),
            ],
            (object)[
                'type' => 'new-annonce',
                'icon' => 'megaphone-fill',
                'title' => 'Nouvelle annonce',
                'description' => 'Une annonce récente a été publiée.',
                'created_at' => now()->subMinutes(15),
            ],
            (object)[
                'type' => 'payment',
                'icon' => 'credit-card-fill',
                'title' => 'Revenu enregistré',
                'description' => 'Un paiement a été confirmé sur la plateforme.',
                'created_at' => now()->subMinutes(30),
            ],
        ]);

        return view('dashboard.admin_new', compact(
            'totalUsers',
            'totalAnnonces',
            'totalRevenue',
            'totalCategories',
            'recentAnnonces',
            'recentUsers',
            'recentActivities'
        ));
    }
}
