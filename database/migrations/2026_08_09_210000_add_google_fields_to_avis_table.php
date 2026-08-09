<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avis', function (Blueprint $table) {
            $table->string('source')->default('manual')->after('id');
            $table->string('google_review_id', 191)->nullable()->unique()->after('source');
            $table->string('auteur_photo_url')->nullable()->after('nom_client');
            $table->timestamp('date_avis')->nullable()->after('texte');
        });
    }

    public function down(): void
    {
        Schema::table('avis', function (Blueprint $table) {
            $table->dropColumn(['source', 'google_review_id', 'auteur_photo_url', 'date_avis']);
        });
    }
};
