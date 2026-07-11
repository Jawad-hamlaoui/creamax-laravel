<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nom_entreprise');
            $table->string('dirigeant');
            $table->string('forme_juridique');
            $table->string('adresse');
            $table->string('siren', 9);
            $table->string('siret', 14);
            $table->string('tva_intra', 20);
            $table->string('ape', 5);
            $table->string('zone_intervention');
            $table->decimal('taux_tva', 5, 2)->default(20.00);
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->text('horaires')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('google_business_url')->nullable();
            $table->string('logo_path')->nullable();
            $table->longText('cgv_texte')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
