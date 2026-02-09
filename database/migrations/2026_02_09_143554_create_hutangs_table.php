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
        Schema::create('hutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kreditur');
            $table->text('keterangan');
            $table->decimal('jumlah', 15, 2);
            $table->date('jatuh_tempo')->nullable();
            $table->string('status')->default('belum_lunas'); // belum_lunas, lunas
            $table->date('tanggal_lunas')->nullable();
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
        Schema::dropIfExists('hutangs');
    }
};
