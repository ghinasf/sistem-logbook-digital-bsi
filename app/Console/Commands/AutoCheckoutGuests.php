<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Logbook;
use Carbon\Carbon;

class AutoCheckoutGuests extends Command
{
    /**
     * Nama perintah yang akan dipanggil sistem.
     */
    protected $signature = 'app:auto-checkout';

    /**
     * Deskripsi perintah.
     */
    protected $description = 'Otomatis checkout tamu yang sudah lebih dari 5 jam';

    /**
     * Eksekusi logika.
     */
    public function handle()
    {
        // 1. Cari tamu yang 'Di Ruang Server' DAN waktu check-in < (Waktu Sekarang - 5 Jam)
        $batasWaktu = Carbon::now()->subHours(5);

        $overdueLogbooks = Logbook::where('status', 'Di Ruang Server')
                                  ->where('check_in', '<=', $batasWaktu)
                                  ->get();

        $count = 0;

        foreach ($overdueLogbooks as $log) {
            // 2. Set waktu checkout menjadi tepat 5 jam setelah dia masuk (asumsi sistem)
            // Atau bisa gunakan now() jika ingin waktu saat sistem ini berjalan.
            $autoCheckoutTime = Carbon::parse($log->check_in)->addHours(5);

            $log->update([
                'check_out' => $autoCheckoutTime,
                'status'    => 'Selesai'
            ]);

            $count++;
        }

        $this->info("Berhasil melakukan auto-checkout untuk {$count} tamu.");
    }
}
