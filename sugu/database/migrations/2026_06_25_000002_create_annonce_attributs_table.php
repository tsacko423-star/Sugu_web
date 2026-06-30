<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonce_attributs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained('annonces')->cascadeOnDelete();
            $table->string('nom');
            $table->string('valeur');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonce_attributs');
    }
};
