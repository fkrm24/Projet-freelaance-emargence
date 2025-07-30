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
        Schema::create('societe_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('societe_id')->index('societe_actions_societe_id_foreign');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->string('contact_type')->nullable();
            $table->string('motif')->nullable();
            $table->date('date_action')->nullable();
            $table->text('commentaire')->nullable();
            $table->text('contenu')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('societe_actions_user_id_foreign');
            $table->timestamps();
            $table->text('action_a_venir')->nullable();
            $table->unsignedTinyInteger('evaluation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societe_actions');
    }
};
