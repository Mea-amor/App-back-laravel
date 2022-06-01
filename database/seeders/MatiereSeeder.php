<?php

namespace Database\Seeders;

use App\Models\Matiere;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Matiere::create([
            'numero' => '0001M',
            'libelle' => 'Anglais',
            'coefficient' => '2',
        ]);
        Matiere::create([
            'numero' => '0002M',
            'libelle' => 'Francais',
            'coefficient' => '3',
        ]);
        Matiere::create([
            'numero' => '0003M',
            'libelle' => 'Informatique',
            'coefficient' => '2.5',
        ]);
        Matiere::create([
            'numero' => '0004M',
            'libelle' => 'Gestion Comptable',
            'coefficient' => '2',
        ]);
    }
}
