<?php

namespace Database\Seeders;

use App\Models\ContactData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactData = new ContactData();
        $contactData::create([
            'address' => 'Calle Medrano 69A',
            'email' => 'georkis.santiesteban@gmail.com',
            'phone' => '55901002'
        ]);
    }
}
