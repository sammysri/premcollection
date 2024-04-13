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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('phone', 255)->nullable();
            $table->string('whatsapp', 255)->nullable();
            $table->string('card_number', 255)->unique()->nullable();
            $table->date('dob')->nullable();
            $table->string('image', 255);
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->text('club_name')->nullable();
            $table->integer('store_id')->nullable();
            $table->text('store_name')->nullable();
            $table->boolean('visit_before')->default(true);
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
