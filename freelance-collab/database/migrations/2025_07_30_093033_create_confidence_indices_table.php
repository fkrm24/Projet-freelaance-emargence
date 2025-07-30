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
        Schema::create('confidence_indices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profil_id')->index('confidence_indices_profil_id_foreign');
            $table->unsignedBigInteger('admin_id')->index('confidence_indices_admin_id_foreign');
            $table->integer('percentage');
            $table->enum('color_code', ['vert', 'orange', 'rouge', 'noir']);
            $table->string('commentaire')->nullable();
            $table->timestamps();
            $table->boolean('is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confidence_indices');
    }
};
