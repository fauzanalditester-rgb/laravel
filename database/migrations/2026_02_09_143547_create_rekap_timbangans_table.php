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
        Schema::create('rekap_timbangans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nomor_kendaraan');
            $table->string('jenis_material');
            $table->decimal('berat_masuk', 12, 2);
            $table->decimal('berat_keluar', 12, 2);
            $table->decimal('berat_bersih', 12, 2);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_timbangans');
    }
};
