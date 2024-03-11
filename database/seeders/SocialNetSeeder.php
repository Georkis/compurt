<?php

namespace Database\Seeders;

use App\Models\SocialNet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialNetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialNet::create([
            'name' => 'facebook',
            'url' => 'https://www.facebook.com',
            'active' => true
        ]);
        SocialNet::create([
            'name' => 'twitter',
            'url' => 'https://twitter.com',
            'active' => true
        ]);
        SocialNet::create([
            'name' => 'instagram',
            'url' => 'https://web.instagram.com',
            'active' => true
        ]);
        SocialNet::create([
            'name' => 'linkedin',
            'url' => 'https://linkedin.com',
            'active' => true
        ]);
    }
}
