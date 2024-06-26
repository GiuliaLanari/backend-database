<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        User::factory()->create([
            'name' => 'Amministratore',
            'surname'=>'Rossi',
            'email' => 'asdf@asdf.asdf',
            'role' => 'admin',
            'phone'=> '46387402804',
        ]);

        User::factory()->create([
            'name' => 'cliente',
            'surname'=>'Bianchi',
            'email' => 'cliente@asd.asd',
            'role' => 'client',
            'phone'=> '264294232342',
        ]);
    }
}
