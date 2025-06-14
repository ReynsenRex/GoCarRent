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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->enum('transmission', ['manual', 'automatic']);
            $table->decimal('price_per_day', 10, 2);
            $table->enum('availability_status', ['available', 'rented', 'maintenance'])->default('available');
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->integer('capacity');
            $table->string('fuel_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
