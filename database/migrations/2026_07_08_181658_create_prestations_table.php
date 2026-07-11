<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestations', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 150);
            $table->string('categorie', 20);
            $table->text('description')->nullable();
            $table->decimal('prix', 8, 2);
            $table->string('unite', 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestations');
    }
};
