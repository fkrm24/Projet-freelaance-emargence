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
        Schema::create('profils', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('profils_user_id_foreign');
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('telephone');
            $table->string('profil');
            $table->text('expertise');
            $table->text('competences');
            $table->integer('experience');
            $table->date('date_diplome');
            $table->string('linkedin')->nullable();
            $table->integer('tjm')->nullable();
            $table->string('cv_path')->nullable();
            $table->timestamps();
            $table->enum('niveau_diplome', ['Licence', 'M1', 'M2', 'Doctorat'])->nullable();
            $table->enum('sexe', ['Homme', 'Femme'])->nullable();
            $table->string('taux_disponibilite')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
