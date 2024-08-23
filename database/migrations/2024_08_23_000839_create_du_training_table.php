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
        Schema::create('du_training', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('weight');
            $table->string('repetitions');
            $table->string('time');
            $table->foreignId('du_user_id')->constrained('du_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('du_trainings');
    }
};
