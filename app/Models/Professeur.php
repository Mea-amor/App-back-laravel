<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;

    public function matieres() {
        return $this->hasMany(Matiere::class);
    }

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero', 'name','categorie'
        ];
}
