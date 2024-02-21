<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        $mahasiswas->load('mataKuliahs');

        return view('pages.mahasiswa', ['mahasiswas' => $mahasiswas]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'krs' => 'required|mimes:pdf|max:2048',
            'nama_matakuliah.*' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::create([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            // Pindahkan file krs ke direktori public/krs dengan nama yang unik
            'krs' => $request->file('krs')->move('krs', $this->generateUniqueFileName($request->file('krs'))),
        ]);

        foreach ($request->nama_matakuliah as $namaMatakuliah) {
            MataKuliah::create([
                'nama_matakuliah' => $namaMatakuliah,
                'id_mahasiswa' => $mahasiswa->id,
            ]);
        }

        return redirect('/')->with('notification', [
            'title' => 'Sukses!',
            'text' => 'Data berhasil disimpan.',
            'type' => 'success',
        ]);
    }

    private function generateUniqueFileName($file)
    {
        $timestamp = now()->timestamp;
        $uniqueId = uniqid();
        $extension = $file->getClientOriginalExtension();
        return "{$timestamp}_{$uniqueId}.{$extension}";
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string|max:255',
            'krs' => 'nullable|mimes:pdf|max:2048', // Krs bisa diubah, bisa tidak
            'nama_matakuliah.*' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);

        $mahasiswa->nama = $request->nama;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->alamat = $request->alamat;

        if ($request->hasFile('krs')) {
            // Hapus file krs yang lama jika ada
            Storage::delete($mahasiswa->krs);

            // Simpan file krs baru ke storage dengan nama yang unik
            $mahasiswa->krs = $request->file('krs')->store('public/krs');
        }

        $mahasiswa->save();

        // Hapus semua mata kuliah yang terkait dengan mahasiswa
        $mahasiswa->mataKuliahs()->delete();

        // Tambahkan mata kuliah yang baru
        foreach ($request->nama_matakuliah as $namaMatakuliah) {
            $mahasiswa->mataKuliahs()->create([
                'nama_matakuliah' => $namaMatakuliah,
            ]);
        }

        return redirect('/')->with('notification', [
            'title' => 'Sukses!',
            'text' => 'Data berhasil diperbarui.',
            'type' => 'success',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus MataKuliah yang terkait dengan Mahasiswa
        MataKuliah::where('id_mahasiswa', $id)->delete();
        // Hapus Mahasiswa
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect('/')->with('notification', [
            'title' => 'Sukses!',
            'text' => 'Data berhasil dihapus.',
            'type' => 'success',
        ]);
    }
}
