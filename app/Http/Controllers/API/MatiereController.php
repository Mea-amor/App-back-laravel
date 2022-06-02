<?php
/**
 * @package Gestion scolaire
 * @subpackage Matiere
 * @author Mamy
 */
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Matiere;
use Validator;
use App\Http\Resources\Matiere as MatiereResource;
use App\Models\Etudiant;

/**
 * Cette classe permet de faire les differentes type de requête entre la base de données et le frontend
 * @package Gestion scolaire
 * @subpackage MatiereController
 */
class MatiereController extends BaseController
{
    /**
     *  Permet de récupérer les listes des matières qui sont limiter par le nombre de pagination.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response retourne une liste de la matière
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

        $tomatiereProf = Matiere::with('professeur');

        if ($sfilterType && $sfiltervalue)
        {
            $tomatiereProf->where($sfilterType, 'LIKE', '%' . $sfiltervalue . '%');
        }
        else if ($ssortbyType && $ssortbyValue)
        {
            $tomatiereProf->orderBy($ssortbyType, $ssortbyValue);
        }

        $tomatiere = $tomatiereProf->paginate($iper_page);

        return $this->sendResponse($tomatiere, 'matiere retrieved successfully.');
    }
    /**
     * Enregistrement d'une matiere dans la base de données
     *
     * @param  \Illuminate\Http\Request  $_srequest requête venant du côté front
     * @return \Illuminate\Http\Response retourne la matiere qui vient d'être enregistrer
     */
    public function store(Request $_srequest)
    {
        $tsinput = $_srequest->all();

        $ovalidator = Validator::make($tsinput, [
            'libelle' => 'required',
            'numero' => 'required'
        ]);

        if ($ovalidator->fails())
        {
            return $this->sendError('Validation Error.', $ovalidator->errors());
        }

        $omatiere = Matiere::create($tsinput);

        return $this->sendResponse(new MatiereResource($omatiere), 'Matiere created successfully.');
    }

    /**
     * Permet de prendre une matière spécifique.
     *
     * @param  int  $iid paramètre qui permet d'identifier une matière à récupérer
     * @return \Illuminate\Http\Response retourne un étudiant avec ses matières
     */
    public function show($_iid)
    {
        $omatiere = Matiere::find($_iid);
        $tomatiereEtudiant = Matiere::find($_iid)->etudiants;

        if (is_null($omatiere))
        {
            return $this->sendError('Matiere not found.');
        }

        return $this->sendResponse([$omatiere, $tomatiereEtudiant], 'Matiere retrieved successfully.');
    }

    /**
     * Modification d'une matière dans la base de données
     *
     * @param  \Illuminate\Http\Request $_srequest requête venant du côté front
     * @param  int  $iid paramètre qui permet d'identifier l'a matière à modifier
     * @return \Illuminate\Http\Response retourne l'etudiant qui vient d'être modifier
     */
    public function update(Request $_srequest, Matiere $matiere)
    {
        $tsinput = $_srequest->all();

        $ovalidator = Validator::make($tsinput, [
            'libelle' => 'required',
            'numero' => 'required'
        ]);

        if ($ovalidator->fails())
         {
            return $this->sendError('Validation Error.', $ovalidator->errors());
        }
        $sprofId = $_srequest->input('professeur_id');
        $setudiantId = $_srequest->input('etudiant_id');
        $brelation = $_srequest->input('remove');

        if ($sprofId)
        {
            $matiere->professeur_id = $sprofId;
        }
        else
        {
            $matiere->professeur_id = null;
        }
        $matiere->libelle = $tsinput['libelle'];
        $matiere->numero = $tsinput['numero'];
        $matiere->coefficient = $tsinput['coefficient'];

        if ($setudiantId and $brelation)
        {
            $oetudiant = Etudiant::find($setudiantId);
            $matiere->etudiants()->sync($oetudiant, false);
        }
        else
        {
            $oetudiant = Etudiant::find($setudiantId);
            $matiere->etudiants()->detach($oetudiant);
        }
        $matiere->save();

        return $this->sendResponse(new MatiereResource($matiere), 'Matiere updated successfully.');
    }

    /**
     * Suppression d'une matière dans la base de données.
     *
     * @param  int   $iid parametre qui permet d'identifier la matière à supprimer
     * @return \Illuminate\Http\Response  retourne une message confirmant la suppression d'une matière
     */
    public function destroy(Matiere $matiere)
    {
        $matiere->delete();

        return $this->sendResponse([], 'Matiere deleted successfully.');
    }
}
