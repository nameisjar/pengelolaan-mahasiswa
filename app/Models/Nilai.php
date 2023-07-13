<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'id__matkul');
    }
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
