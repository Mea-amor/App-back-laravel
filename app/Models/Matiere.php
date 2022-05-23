<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

     public function professeur() {
        return $this->belongsTo(Professeur::class,"professeur_id");
    }

     /**
     * The matiere that belong to the etudiants.
     */
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero', 'libelle','coefficient'    ];
}
