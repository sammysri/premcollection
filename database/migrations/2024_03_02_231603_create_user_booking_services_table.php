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
        Schema::create('user_booking_services', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('service_id')->nullable();
            $table->string('service_type');
            $table->enum('status', ['under-process', 'cancelled', 'confirmed']);
            $table->text('extra_data');
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_booking_services');
    }
};
