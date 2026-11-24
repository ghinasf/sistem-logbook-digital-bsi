<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Logbook;
use App\Models\Guest; // Pastikan ini di-import
use App\Exports\LogbookExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash; // <--- Wajib ada biar bisa cek & enkripsi password
use Illuminate\Validation\Rules\Password; // Opsional, untuk validasi password kuat
use App\Models\User;

class AdminController extends Controller
{
    // --- 1. LOGIN & AUTH ---
    public function showLogin() { return view('admin.login'); }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }
        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // --- 2. DASHBOARD ---
    public function dashboard(Request $request)
    {
        // Grafik 7 Hari Terakhir
        $chartData = Logbook::select(DB::raw('DATE(check_in) as date'), DB::raw('count(*) as count'))
            ->where('check_in', '>=', now()->subDays(7))
            ->groupBy('date')->orderBy('date', 'ASC')->get();

        // Data Tamu HARI INI
        $todayQuery = Logbook::with(['guest', 'purpose'])->whereDate('check_in', today())->orderBy('check_in', 'DESC');
        if ($request->filled('search')) {
            $search = $request->search;
            $todayQuery->whereHas('guest', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('institution', 'like', "%{$search}%");
            });
        }
        $todaysLogbooks = $todayQuery->get();

        return view('admin.dashboard', compact('chartData', 'todaysLogbooks'));
    }

    // --- 3. HALAMAN VISITORS (Pencarian Tanggal + Text) ---
    public function visitors(Request $request)
    {
        $query = Logbook::with(['guest', 'purpose'])->orderBy('check_in', 'DESC');

        // A. Filter Tanggal (BARU)
        if ($request->filled('date')) {
            $query->whereDate('check_in', $request->date);
        }

        // B. Filter Pencarian Text
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('guest', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        // Pakai variabel $logbooks biar standar
        $logbooks = $query->paginate(10)->withQueryString();

        return view('admin.visitors', compact('logbooks'));
    }

    // --- 4. SHOW DETAIL (BARU) ---
    public function show($id)
    {
        $logbook = Logbook::with('guest')->findOrFail($id);
        return view('admin.logbook.show', compact('logbook'));
    }

    // --- 5. HAPUS DATA ---
    public function destroy($id)
    {
        $logbook = Logbook::findOrFail($id);
        $guestId = $logbook->guest_id;

        $logbook->delete(); // Hapus Logbook

        // Cek Sinkronisasi (Hapus tamu jika tidak ada history lain)
        $sisaKunjungan = Logbook::where('guest_id', $guestId)->count();
        if ($sisaKunjungan == 0) {
            $guest = Guest::find($guestId);
            if ($guest) $guest->delete();
        }

        return back()->with('success', 'Data berhasil dihapus.');
    }

    // --- 6. EXPORT LAPORAN ---
    public function exportReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $fileName = 'logbook_' . date('Ymd_His');

        if ($request->format == 'excel') {
            return Excel::download(new LogbookExport($startDate, $endDate), $fileName . '.xlsx');
        } elseif ($request->format == 'pdf') {
            $logbooks = Logbook::with(['guest', 'purpose'])
                ->whereBetween('check_in', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->get();
            $pdf = Pdf::loadView('admin.pdf_report', compact('logbooks', 'startDate', 'endDate'));
            return $pdf->download($fileName . '.pdf');
        }
    }
    // --- 7. MANAJEMEN PROFIL (GANTI PASSWORD) ---

    public function showProfile()
    {
        return view('admin.profile');
    }

    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // 2. Cek Password Lama
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // 3. Update Password Baru (PERBAIKAN DISINI)
        // Kita cari user secara manual biar VS Code tidak bingung
        $user = User::find(Auth::id());

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
