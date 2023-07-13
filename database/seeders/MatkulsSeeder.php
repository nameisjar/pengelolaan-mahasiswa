<?php

namespace Database\Seeders;

use App\Models\Matkul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatkulsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Matkul::create([
            'matkul' => 'Jaringan Komputer'
        ]);
        Matkul::create([
            'matkul' => 'Pemrograman Website'
        ]);
        Matkul::create([
            'matkul' => 'Data Mining'
        ]);
        Matkul::create([
            'matkul' => 'Algo 2'
        ]);
        Matkul::create([
            'matkul' => 'Algo 1'
        ]);
        Matkul::create([
            'matkul' => 'Analisa dan Perancangan Sistem'
        ]);
        Matkul::create([
            'matkul' => 'Sistem Basis Data'
        ]);
        Matkul::create([
            'matkul' => 'Metodologi Penelitian'
        ]);
        Matkul::create([
            'matkul' => 'Pengantar kecerdasan Buatan'
        ]);
        Matkul::create([
            'matkul' => 'Interaksi Manusia dan Komputer'
        ]);
        Matkul::create([
            'matkul' => 'Etika Profesi'
        ]);
    }
}
