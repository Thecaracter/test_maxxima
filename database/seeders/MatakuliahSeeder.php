<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataKuliah::create([
            'nama_matakuliah' => 'Nama Matakuliah 1',
            'id_mahasiswa' => 1,
            'jenis_kelamin' => 'Laki-laki',
        ]);

        MataKuliah::create([
            'nama_matakuliah' => 'Nama Matakuliah 2',
            'id_mahasiswa' => 2,
            'jenis_kelamin' => 'Perempuan',
        ]);
    }
}
