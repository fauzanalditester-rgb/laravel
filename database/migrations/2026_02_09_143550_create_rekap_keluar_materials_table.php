<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekap_keluar_materials', function (Blueprint $table) {
            $table->id();
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->decimal('total_keluar', 12, 2);
            $table->decimal('total_nilai', 15, 2);
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
        Schema::dropIfExists('rekap_keluar_materials');
    }
};
