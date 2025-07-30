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
        Schema::table('references', function (Blueprint $table) {
            $table->foreign(['experience_id'])->references(['id'])->on('experiences')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['profil_id'])->references(['id'])->on('profils')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('references', function (Blueprint $table) {
            $table->dropForeign('references_experience_id_foreign');
            $table->dropForeign('references_profil_id_foreign');
        });
    }
};
