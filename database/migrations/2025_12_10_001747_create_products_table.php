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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relasi ke tabel categories
        $table->string('thumbnail')->nullable();
        $table->text('description');
        $table->decimal('price', 10, 2); // Format uang (10 digit, 2 desimal)
        $table->integer('stock')->default(0);
        $table->boolean('is_active')->default(true); // Untuk menyembunyikan produk tanpa hapus
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
