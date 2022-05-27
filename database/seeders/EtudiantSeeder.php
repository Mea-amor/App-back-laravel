<?php

namespace Database\Seeders;
use App\Models\Etudiant;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //'img', 'numero','name','sexe'
         Etudiant::create([
            'img' => 'img1',
            'numero' => '0001E',
            'name' => 'Nantenaina',
            'sexe' => 'masculin',
        ]);
          Etudiant::create([
            'img' => 'img2',
            'numero' => '0002E',
            'name' => 'Gerard',
            'sexe' => 'masculin',
          ]);
            Etudiant::create([
            'img' => 'img3',
            'numero' => '0003E',
            'name' => 'Felana',
            'sexe' => 'feminin',
            ]);
              Etudiant::create([
               'img' => 'img4',
            'numero' => '0004E',
            'name' => 'Lidia',
            'sexe' => 'feminin',
        ]);
    }
}
