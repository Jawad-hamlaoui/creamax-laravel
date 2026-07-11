<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20)->unique();
            $table->unsignedSmallInteger('annee');
            $table->unsignedInteger('sequence');
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->decimal('sous_total', 10, 2)->default(0);
            $table->decimal('tva_taux', 5, 2)->default(20.00);
            $table->decimal('tva_montant', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->smallInteger('validite_jours')->default(30);
            $table->string('status', 20)->default('brouillon');
            $table->date('date_creation');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['annee', 'sequence']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
