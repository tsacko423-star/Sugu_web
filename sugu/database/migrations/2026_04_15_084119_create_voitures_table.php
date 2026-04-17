<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('voitures', function (Blueprint $table) {
        $table->id();
        $table->string('marque'); // ex: Mercedes
        $table->string('modele'); // ex: C300
        $table->integer('prix');
        $table->integer('annee')->nullable();
        $table->string('image');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voitures');
    }
};
