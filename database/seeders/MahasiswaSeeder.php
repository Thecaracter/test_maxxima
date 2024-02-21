<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            'nama' => 'Nama Mahasiswa 1',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Alamat Mahasiswa 1',
            'krs' => 'KRS Mahasiswa 1',
        ]);

        Mahasiswa::create([
            'nama' => 'Nama Mahasiswa 2',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Alamat Mahasiswa 2',
            'krs' => 'KRS Mahasiswa 2',
        ]);

    }
}
