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
        Schema::create('ptj', function (Blueprint $table) {
            $table->id();
            $table->string("nama_ptj");
            $table->integer("kod_ptj");
            $table->string("alamat");
            $table->string("pengarah");
            $table->timestamps();
        });

        Schema::create('bahagian', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("ptj_id");
            $table->string("bahagian");
            $table->timestamps();
        });
Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("bahagian_id");
            $table->string("unit");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptjs');
    }
};
