<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categorie::updateOrCreate(['name' => 'Immobilier'], ['icon' => 'house']);
        Categorie::updateOrCreate(['name' => 'Voitures'], ['icon' => 'car-front']);
        Categorie::updateOrCreate(['name' => 'Emploi'], ['icon' => 'briefcase']);
        Categorie::updateOrCreate(['name' => 'Autres'], ['icon' => 'tag']);
    }
}
