<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    // Menampilkan halaman surat masuk
    public function index()
    {
        return view('suratMasuk');
    }

    // Menampilkan halaman tambah surat masuk
    public function create()
    {
        return view('tambahSuratMasuk');
    }

    // Cek validasi untuk di simpan ke database
    public function store(Request $request)
    {
        // Cek validasi inputan
        $request->validate([
            'nomor_berkas' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nomor' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'ditujukan_kepada' => 'nullable|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [

            'file_surat.max' => 'Ukuran file maksimal 10MB.',
            'file_surat.mimes' => 'File harus berupa PDF/doc/docx.',

        ]);

        // Cek apakah nomor_berkas sudah pernah ada
        $exists = SuratMasuk::where('nomor', $request->nomor)->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Surat dengan nomor surat ini sudah ada.');
        }

        // Simpan file surat jika ada
        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $originalName = $request->file('file_surat')->getClientOriginalName();
            $filePath = $request->file('file_surat')->storeAs('surat_masuk', $originalName, 'public');
        }

        // Menyimpan ke database
        SuratMasuk::create([
            'nomor_berkas' => $request->nomor_berkas,
            'pengirim' => $request->pengirim,
            'tanggal' => $request->tanggal,
            'nomor' => $request->nomor,
            'perihal' => $request->perihal,
            'ditujukan_kepada' => $request->ditujukan_kepada,
            'file_surat' => $filePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('suratMasuk.create')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    // Menampilkan data surat masuk
    public function get(Request $request)
    {
        // Pencarian sesuai inputan, berdasarkan nomor berkas, pengirim, perihal
        $query = SuratMasuk::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_berkas', 'like', "%$search%")
                    ->orWhere('pengirim', 'like', "%$search%")
                    ->orWhere('perihal', 'like', "%$search%")
                    ->orWhere('ditujukan_kepada', 'like', "%$search%");
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
        $suratMasuk = $query->latest()->paginate(10)->withQueryString();
        return view('suratMasuk', compact('suratMasuk')); // Kirim ke view
    }

    // Menampilkan halaman edit surat masuk
    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        return view('editSuratMasuk', compact('surat'));
    }

    // Cek validasi dan menyimpan perubahan yang dilakukan
    public function update(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        // Validasi input
        $request->validate([
            'nomor_berkas' => 'required|string|max:255',
            'pengirim' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nomor' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'ditujukan_kepada' => 'nullable|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ], [

            'file_surat.max' => 'Ukuran file maksimal 10MB.',
            'file_surat.mimes' => 'File harus berupa PDF atau word (doc,docx).',

        ]);

        // Jika ada file baru baru di-upload
        if ($request->hasFile('file_surat')) {
            if ($surat->file_surat && file_exists(storage_path('app/public/' . $surat->file_surat))) {
                unlink(storage_path('app/public/' . $surat->file_surat));
            }

            // Simpan file surat baru
            $originalName = $request->file('file_surat')->getClientOriginalName();
            $filePath = $request->file('file_surat')->storeAs('surat_masuk', $originalName, 'public');
            $surat->file_surat = $filePath;
        }

        // Update data lainnya dan menyimpan perubahan yang dilakukan
        $surat->nomor_berkas = $request->nomor_berkas;
        $surat->pengirim = $request->pengirim;
        $surat->tanggal = $request->tanggal;
        $surat->nomor = $request->nomor;
        $surat->perihal = $request->perihal;
        $surat->ditujukan_kepada = $request->ditujukan_kepada;

        $surat->save();

        return redirect()->route('suratMasuk')->with('success', 'Data surat masuk berhasil diperbarui.');
    }
}