<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('societe_actions', function (Blueprint $table) {
            $table->text('action_a_venir')->nullable();
        });
    }
    public function down() {
        Schema::table('societe_actions', function (Blueprint $table) {
            $table->dropColumn('action_a_venir');
        });
    }
};
