<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('logbooks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
        $table->foreignId('purpose_id')->constrained('purposes');
        $table->timestamp('check_in')->useCurrent(); // Otomatis waktu saat ini
        $table->timestamp('check_out')->nullable(); // Kosong dulu saat baru masuk
        $table->enum('status', ['Di Ruang Server', 'Selesai'])->default('Di Ruang Server');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
