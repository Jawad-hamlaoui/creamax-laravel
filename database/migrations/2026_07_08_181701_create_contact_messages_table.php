<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('prenom', 100);
            $table->string('nom', 100);
            $table->string('telephone', 30);
            $table->string('email', 150);
            $table->string('commune', 100)->nullable();
            $table->string('prestation', 100)->nullable();
            $table->text('message');
            $table->string('audio_path')->nullable();
            $table->unsignedSmallInteger('audio_duration_seconds')->nullable();
            $table->string('status', 20)->default('nouveau');
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
