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
 * Cette classe sert du modele à la table professeur dans la base de données
 * @package App
 * @subpackage Models
 */
class Professeur extends Model
{
    use HasFactory;

    /**
     * Une relation un-à-plusieurs est utilisée ici pour définir la relation  entre
     * l'entité professeur et matière
     */
    public function matieres() {
        return $this->hasMany(Matiere::class);
    }

        /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'numero', 'name','categorie'
        ];
}
