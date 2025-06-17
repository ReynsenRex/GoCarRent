<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosTable extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->decimal('discount_pct', 5, 2);
            $table->timestamps();
        });

        // Tambahkan kolom promo_id ke bookings jika ingin relasi
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('promo_id')->nullable()->after('status');

            $table->foreign('promo_id')->references('id')->on('promos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['promo_id']);
            $table->dropColumn('promo_id');
        });

        Schema::dropIfExists('promos');
    }
}