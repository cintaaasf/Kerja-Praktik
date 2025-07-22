<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratKeluarController extends Controller
{
    // Menampilkan halaman surat keluar
    public function index()
    {
        return view('suratKeluar');
    }

    // Menamilkan halaman tambah surat keluar
    public function create()
    {
        return view('tambahSuratKeluar');
    }

    // Cek validasi untuk di simpan ke database
    public function store(Request $request)
    {
        // Cek validasi
        $request->validate([
            'nomor_berkas' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'perihal' => 'required|string|max:255',
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_terima' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'file_surat.max' => 'Ukuran file maksimal 10MB.',
            'file_surat.mimes' => 'File harus berupa PDF/doc/docx.',
        ]);

        // Cek apakah nomor_surat sudah pernah ada
        $exists = SuratKeluar::where('nomor_surat', $request->nomor_surat)->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Surat dengan nomor surat ini sudah ada.');
        }

        // Simpan file surat jika ada file surat yang mau ditambahkan
        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $originalName = $request->file('file_surat')->getClientOriginalName();
            $filePath = $request->file('file_surat')->storeAs('surat_keluar', $originalName, 'public');
        }

        // Menyimpan ke database
        SuratKeluar::create([
            'nomor_berkas' => $request->nomor_berkas,
            'penerima' => $request->penerima,
            'tanggal' => $request->tanggal,
            'perihal' => $request->perihal,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_terima' => $request->tanggal_terima,
            'file_surat' => $filePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('suratKeluar.create')->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    // Menampilkan data surat keluar
    public function get(Request $request)
    {
        // Pencarian sesuai inputan, berdasarkan nomor berkas, penerima, perihal
        $query = SuratKeluar::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_berkas', 'like', "%$search%")
                    ->orWhere('penerima', 'like', "%$search%")
                    ->orWhere('perihal', 'like', "%$search%");
            });
        }

        // Filter Berdasarkan Tanggal
        if ($request->filled('tanggal')) {
            try {
                $tanggal = \Carbon\Carbon::parse($request->tanggal)->format('Y-m-d');
                $query->whereDate('tanggal', $tanggal);
            } catch (\Exception $e) {
                // Abaikan filter kalau tanggal tidak valid
            }
        }

        // Menampilkan 10 data per halaman
        $suratKeluar = $query->latest()->paginate(10)->withQueryString();
        return view('suratKeluar', compact('suratKeluar')); // Kirim ke view
    }

    // Menampilkan halaman edit surat keluar
    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        return view('editSuratKeluar', compact('surat'));
    }

    // Cek validasi dan menyimpan perubahan yang dilakukan
    public function update(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        // Validasi input
        $request->validate([
            'nomor_berkas' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'perihal' => 'required|string|max:255',
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_terima' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [
            'file_surat.max' => 'Ukuran file maksimal 10MB.',
            'file_surat.mimes' => 'File harus berupa PDF atau word(docdocx)',
        ]);

        // Jika ada file surat baru di-upload
        if ($request->hasFile('file_surat')) {
            if ($surat->file_surat && file_exists(storage_path('app/public/' . $surat->file_surat))) {
                unlink(storage_path('app/public/' . $surat->file_surat));
            }

            // Simpan file surat baru
            $originalName = $request->file('file_surat')->getClientOriginalName();
            $filePath = $request->file('file_surat')->storeAs('surat_keluar', $originalName, 'public');
            $surat->file_surat = $filePath;
        }

        // Update data lainnya dan menyimpan perubahan yang dilakukan
        $surat->nomor_berkas = $request->nomor_berkas;
        $surat->penerima = $request->penerima;
        $surat->tanggal = $request->tanggal;
        $surat->perihal = $request->perihal;
        $surat->nomor_surat = $request->nomor_surat;
        $surat->tanggal_terima = $request->tanggal_terima;

        $surat->save();

        return redirect()->route('suratKeluar')->with('success', 'Data surat masuk berhasil diperbarui.');
    }
}