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
        Schema::table('manual_contacts', function (Blueprint $table) {
            $table->foreign(['societe_id'])->references(['id'])->on('contacts')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manual_contacts', function (Blueprint $table) {
            $table->dropForeign('manual_contacts_societe_id_foreign');
        });
    }
};
