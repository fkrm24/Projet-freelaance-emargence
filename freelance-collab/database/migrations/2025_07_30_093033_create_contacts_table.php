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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('siren', 9)->nullable()->unique();
            $table->string('code_naf', 7)->nullable();
            $table->string('tva', 13)->nullable()->unique();
            $table->string('contact_nom')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_poste')->nullable();
            $table->timestamps();

            $table->index(['contact_nom', 'contact_email', 'contact_poste']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
