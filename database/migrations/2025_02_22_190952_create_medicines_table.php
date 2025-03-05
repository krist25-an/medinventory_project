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
    Schema::create('medicines', function (Blueprint $table) {
      $table->id();
      $table->string('nama');
      $table->text('deskripsi')->nullable();
      $table->integer('stok')->default(0);
      $table->integer('stok_min')->default(0);
      $table->decimal('harga', 10, 2)->nullable();
      $table->string('satuan');
      $table->date('expired');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('medicines');
  }
};
