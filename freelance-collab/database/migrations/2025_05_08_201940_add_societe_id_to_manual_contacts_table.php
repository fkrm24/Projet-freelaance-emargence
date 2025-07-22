<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('manual_contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('societe_id')->nullable()->after('id');
            $table->foreign('societe_id')->references('id')->on('contacts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('manual_contacts', function (Blueprint $table) {
            $table->dropForeign(['societe_id']);
            $table->dropColumn('societe_id');
        });
    }
};
