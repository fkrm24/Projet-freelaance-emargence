<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('societe_actions', function (Blueprint $table) {
            $table->unsignedTinyInteger('evaluation')->nullable();
        });
    }
    public function down() {
        Schema::table('societe_actions', function (Blueprint $table) {
            $table->dropColumn('evaluation');
        });
    }
};
