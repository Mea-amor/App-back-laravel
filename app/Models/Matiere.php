<?php

/**
 * @package App
 * @subpackage Models
 * @author Mamy
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Cette classe sert du modele à la table matiere dans la base de données
 * @package App
 * @subpackage Models
 */
class Matiere extends Model
{
    use HasFactory;


    /**
     * Une relation plusieurs-à-un est utilisée ici pour définir la relation  entre
     * l'entité matiere et professeur
     */
     public function professeur() {
        return $this->belongsTo(Professeur::class,"professeur_id");
    }

     /**
      * Une relation plusieurs-à-plusieurs est utilisée ici pour définir la relation  entre
     * l'entité matiere et etudiants
     */
    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class);
    }
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'numero', 'libelle','coefficient'    ];
}
