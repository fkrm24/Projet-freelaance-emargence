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
        Schema::table('societe_actions', function (Blueprint $table) {
            $table->foreign(['societe_id'])->references(['id'])->on('contacts')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('societe_actions', function (Blueprint $table) {
            $table->dropForeign('societe_actions_societe_id_foreign');
            $table->dropForeign('societe_actions_user_id_foreign');
        });
    }
};
