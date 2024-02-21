<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = ['nama', 'jenis_kelamin', 'alamat', 'krs'];
    public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class, 'id_mahasiswa', 'id');
    }
}
