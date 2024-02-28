<?php

namespace Database\Seeders;

use App\Models\Seccion;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seccion::create([
            "name" => "Slider 1",
            "image" => "somos_el_mundo.png"
        ]);

        Seccion::create([
            "name" => "Slider 2",
            "image" => "mi_terruno.png"
        ]);

    }
}
