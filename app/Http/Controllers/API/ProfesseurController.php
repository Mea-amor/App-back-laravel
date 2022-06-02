<?php

/**
 * @package Gestion scolaire
 * @subpackage Professeur
 * @author Mamy
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Professeur;
use Validator;
use App\Http\Resources\Professeur as ProfesseurResource;

/**
 * Cette classe permet de faire les differentes type de requête entre la base de données et le frontend
 * @package Gestion scolaire
 * @subpackage ProfesseurController
 */
class ProfesseurController extends BaseController
{
    /**
     *  Permet de récupérer les listes des professeurs qui sont limiter par le nombre de pagination.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response retourne une liste de professeur
     */
    public function index(Request $_srequest)
    {
        /*  variables qui stockent le type de filtre à faire */
        $sfilterType = $_srequest->input('type');
        $sfiltervalue = $_srequest->input('value');

         /*  variables qui stockent le type de trie à faire soit par asc soit par desc */
        $ssortbyType = $_srequest->input('sortbyType');
        $ssortbyValue = $_srequest->input('sortbyValue');

        $iper_page = intVal($_srequest->input('per_page'));

        $toprofesseurMat = Professeur::with('matieres');

        if ($sfilterType && $sfiltervalue)
        {
            $toprofesseurMat->where($sfilterType, 'LIKE', '%' . $sfiltervalue . '%');
        }
        else if ($ssortbyType && $ssortbyValue)
        {
            $toprofesseurMat->orderBy($ssortbyType, $ssortbyValue);
        }

        $toprofesseur = $toprofesseurMat->paginate($iper_page);

        return $this->sendResponse($toprofesseur, 'Professeur retrieved successfully.');
    }
    /**
     * Enregistrement d'un professeur dans la base de données
     *
     * @param  \Illuminate\Http\Request  $_srequest requête venant du côté front
     * @return \Illuminate\Http\Response retourne le professeur qui vient d'être enregistrer
     */
    public function store(Request $_srequest)
    {
        $tsinput = $_srequest->all();

        $ovalidator = Validator::make($tsinput, [
            'name' => 'required',
            'numero' => 'required'
        ]);

        if ($ovalidator->fails())
        {
            return $this->sendError('Validation Error.', $ovalidator->errors());
        }

        $oprofesseur = Professeur::create($tsinput);

        return $this->sendResponse(new ProfesseurResource($oprofesseur), 'Professeur created successfully.');
    }

    /**
     * Permet de prendre un professeur spécifique.
     *
     * @param  int  $iid paramètre qui permet d'identifier un professeur à récupérer
     * @return \Illuminate\Http\Response retourne un professeur avec ses matières
     */
    public function show($_iid)
    {
        $oprofesseur = Professeur::find($_iid);
        $tomatieres = Professeur::find($_iid)->matieres;

        if (is_null($oprofesseur))
        {
            return $this->sendError('Professeur not found.');
        }

        return $this->sendResponse([$oprofesseur, $tomatieres], 'Professeur retrieved successfully.');
    }

    /**
     *  Modification d'un professeur dans la base de données
     *
     * @param  \Illuminate\Http\Request $_srequest requête venant du côté front
     * @param  int  $iid paramètre qui permet d'identifier le  professeur à modifier
     * @return \Illuminate\Http\Response  retourne le  professeur qui vient d'être modifier
     */
    public function update(Request $_srequest, Professeur $professeur)
    {
        $tsinput = $_srequest->all();

        $ovalidator = Validator::make($tsinput, [
            'name' => 'required',
            'numero' => 'required'
        ]);

        if ($ovalidator->fails())
        {
            return $this->sendError('Validation Error.', $ovalidator->errors());
        }

        $professeur->name = $tsinput['name'];
        $professeur->numero = $tsinput['numero'];
        $professeur->categorie = $tsinput['categorie'];
        $professeur->save();

        return $this->sendResponse(new ProfesseurResource($professeur), 'Professeur updated successfully.');
    }

    /**
     *Suppression d'un professeur dans la base de données..
     *
     * @param  int  $iid parametre qui permet d'identifier le professeur à supprimer
     * @return \Illuminate\Http\Response  retourne une message confirmant la suppression d'un professeur
     */
    public function destroy(Professeur $professeur)
    {
        $professeur->delete();

        return $this->sendResponse([], 'Professeur deleted successfully.');
    }
}
