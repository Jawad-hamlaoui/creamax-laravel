<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devis_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devis_id')->constrained('devis')->cascadeOnDelete();
            $table->foreignId('prestation_id')->nullable()->constrained('prestations')->nullOnDelete();
            $table->string('description', 255);
            $table->decimal('quantite', 8, 2)->default(1);
            $table->decimal('prix_unitaire', 8, 2)->default(0);
            $table->unsignedInteger('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devis_lignes');
    }
};
