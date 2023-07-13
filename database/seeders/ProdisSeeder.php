<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prodi::create([
            'prodi' => 'Sistem Informasi'
        ]);
        Prodi::create([
            'prodi' => 'Teknologi Informasi'
        ]);
        Prodi::create([
            'prodi' => 'Informatika'
        ]);
    }
}
