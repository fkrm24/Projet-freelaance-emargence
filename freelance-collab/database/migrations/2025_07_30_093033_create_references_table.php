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
        Schema::create('references', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profil_id')->index('references_profil_id_foreign');
            $table->unsignedBigInteger('experience_id')->nullable()->index('references_experience_id_foreign');
            $table->string('entreprise')->nullable();
            $table->string('secteur')->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->string('fonction');
            $table->string('email');
            $table->string('telephone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('references');
    }
};
