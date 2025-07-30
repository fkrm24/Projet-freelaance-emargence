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
        Schema::table('confidence_indices', function (Blueprint $table) {
            $table->foreign(['admin_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['profil_id'])->references(['id'])->on('profils')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confidence_indices', function (Blueprint $table) {
            $table->dropForeign('confidence_indices_admin_id_foreign');
            $table->dropForeign('confidence_indices_profil_id_foreign');
        });
    }
};
