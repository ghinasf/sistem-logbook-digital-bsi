<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Logbook;
use App\Models\Purpose;

class GuestController extends Controller
{
    // 1. Tampilkan Halaman Utama (Form Registrasi)
    public function index()
    {
        // Ambil data tujuan kunjungan untuk dropdown
        $purposes = Purpose::where('is_active', true)->get();
        return view('guest.registration', compact('purposes'));
    }

    // 2. Proses Simpan & Auto Check-in
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'institution' => 'required',
            'id_number' => 'required',
            'phone' => 'required',
            'purpose_id' => 'required'
        ]);

        // Cek apakah data tamu sudah ada (berdasarkan NIK), jika belum buat baru
        // Sesuai konsep Master Data agar tidak input ulang full
        $guest = Guest::firstOrCreate(
            ['id_number' => $request->id_number],
            [
                'name' => $request->name,
                'institution' => $request->institution,
                'phone' => $request->phone,
            ]
        );

        // Update data jika ada perubahan (opsional, untuk memastikan data terbaru)
        $guest->update([
            'name' => $request->name,
            'institution' => $request->institution,
            'phone' => $request->phone,
        ]);

        // Buat Transaksi Logbook (Auto Check-in)
        $logbook = Logbook::create([
            'guest_id' => $guest->id,
            'purpose_id' => $request->purpose_id,
            'check_in' => now(), // Waktu server otomatis
            'status' => 'Di Ruang Server'
        ]);

        // Redirect ke halaman standby checkout membawa ID Logbook
        return redirect()->route('guest.checkout-view', $logbook->id);
    }

    // 3. Tampilkan Halaman Standby (Tombol Checkout)
    public function checkoutView($id)
    {
        $logbook = Logbook::with(['guest', 'purpose'])->findOrFail($id);

        // Validasi: Jika status sudah selesai, tidak boleh akses halaman ini lagi
        if ($logbook->status == 'Selesai') {
            return redirect()->route('guest.index')->with('status', 'Kunjungan telah berakhir.');
        }

        return view('guest.checkout', compact('logbook'));
    }

    // 4. Proses Checkout
    public function processCheckout($id)
    {
        $logbook = Logbook::findOrFail($id);

        $logbook->update([
            'check_out' => now(), // Waktu server otomatis [cite: 652]
            'status' => 'Selesai'
        ]);

        return redirect()->route('guest.index')->with('success', 'Terima kasih! Kunjungan Anda telah tercatat selesai.');
    }
}
