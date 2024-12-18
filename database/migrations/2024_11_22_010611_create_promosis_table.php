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
        Schema::create('promosis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->nullable()->constrained('produks')->onDelete('cascade'); // ID produk yang terkait dengan promosi
            $table->boolean('applies_to_all')->default(false); // apakah promosi berlaku untuk semua produk
            $table->enum('type', ['quantity_discount', 'coupon']); // jenis promosi: quantity_discount, coupon
            $table->string('description')->nullable(); // deskripsi singkat
            $table->integer('quantity_required')->nullable(); // jumlah pembelian minimum untuk quantity_discount
            $table->decimal('minimum_purchase_amount', 10)->nullable(); // jumlah pembelian minimum untuk mendapatkan diskon coupon
            $table->decimal('discount_percentage', 5, 2); // persentase diskon
            $table->string('coupon_code')->nullable(); // kode kupon
            $table->date('start_date'); // tanggal mulai promosi
            $table->date('end_date'); // tanggal berakhir promosi
            $table->boolean('active')->default(true); // status aktif/non-aktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promosis');
    }
};

