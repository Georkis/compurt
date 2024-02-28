<?php

namespace Database\Seeders;

use App\Models\Seccion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            "name" => "Georkis",
            "lastname" => "Santiesteban",
            "phone" => "+5355901002",
            "email" => "georkis.santiesteban@gmail.com",
            "active" => true,
            "password" => Hash::make(value: "123456"),
        ]);

        $admin->assignRole('Admin');

        $moderador = User::create([
            "name" => "Modedador",
            "lastname" => "Dev",
            "phone" => "+5300000000",
            "email" => "moderador@jovenclub.com",
            "active" => true,
            "password" => Hash::make(value: "123456"),
        ]);

        $moderador->assignRole('Moderador');

        //Asign seccion
        /**
         * @var User $admin
         */
        // $admin->seccions()->attach([1,2]);
    }
}
