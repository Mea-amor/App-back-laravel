<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

     /**
     * The students that belong to the matiere.
     */
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'img', 'numero','name','sexe'
    ];
}
