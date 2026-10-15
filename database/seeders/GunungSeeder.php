<?php

namespace Database\Seeders;

use App\Models\Gunung;
use Illuminate\Database\Seeder;

class GunungSeeder extends Seeder
{
    public function run(): void
    {
        Gunung::create([
            'nama_gunung' => 'Gunung Semeru',
            'ketinggian' => 3676,
            'lokasi' => 'Jawa Timur'
        ]);

        Gunung::create([
            'nama_gunung' => 'Gunung Rinjani',
            'ketinggian' => 3726,
            'lokasi' => 'Nusa Tenggara Barat'
        ]);
    }
}