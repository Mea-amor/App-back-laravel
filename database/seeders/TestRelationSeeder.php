<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Professeur;

class TestRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            $etudiant= Etudiant::create([
            'img' => 'img1',
            'numero' => '0001E',
            'name' => 'Nantenaina',
            'sexe' => 'masculin',
        ]);

           $professeur=Professeur::create([
            'numero' => '0001P',
            'name' => 'Paul',
            'categorie' => 'A',
        ] );

            $matiere= Matiere::create([
            'numero' => '0001M',
            'libelle' => 'Anglais',
            'coefficient' => '2',
            'professeur_id'=>$professeur->id

         ]);

         $etudiant->matieres()->attach($matiere);

    }
}
