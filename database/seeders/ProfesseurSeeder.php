<?php

namespace Database\Seeders;

use App\Models\Professeur;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Professeur::create([
            'numero' => '0001P',
            'name' => 'Paul',
            'categorie' => 'A',
        ]);
        Professeur::create([
            'numero' => '0002P',
            'name' => 'Piere',
            'categorie' => 'B',
        ]);
        Professeur::create([
            'numero' => '0001P',
            'name' => 'Serge',
            'categorie' => 'A',
        ]);
        Professeur::create([
            'numero' => '0001P',
            'name' => 'Tina',
            'categorie' => 'B',
        ]);
    }
}
