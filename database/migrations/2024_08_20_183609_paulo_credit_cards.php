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
        schema::create('paulo_credit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->string('brand');
            $table->boolean('is_credit')->default(true);
            $table->foreignId('user_id')->constrained('paulo_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
