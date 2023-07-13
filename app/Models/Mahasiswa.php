<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id__prodis');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
    public function nilai()
    {
        return $this->belongsTo(Nilai::class);
    }
}
