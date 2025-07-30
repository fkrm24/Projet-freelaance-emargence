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
        Schema::table('contact_societe', function (Blueprint $table) {
            $table->foreign(['reference_id'])->references(['id'])->on('references')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['societe_id'])->references(['id'])->on('contacts')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_societe', function (Blueprint $table) {
            $table->dropForeign('contact_societe_reference_id_foreign');
            $table->dropForeign('contact_societe_societe_id_foreign');
        });
    }
};
