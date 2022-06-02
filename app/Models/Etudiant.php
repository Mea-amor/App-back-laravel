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
 * Cette classe sert du modele à la table etudiant dans la base de données
 * @package Gestion scolaire
 * @subpackage  App\Models
 * @author Mamy
 */
class Etudiant extends Model
{
    use HasFactory;

       /**
      * Une relation plusieurs-à-plusieurs est utilisée ici pour définir la relation  entre
     * l'entité etudiants et matières
     */
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class);
    }

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'img', 'numero', 'name', 'sexe'
    ];
}
