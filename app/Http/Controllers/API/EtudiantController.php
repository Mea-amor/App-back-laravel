<?php
/**
 * @package Gestion scolaire
 * @subpackage Etudiant
 * @author Mamy
 */
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Etudiant;
use Validator;
use App\Http\Resources\Etudiant as EtudiantResource;

/**
 * Cette classe permet de faire les differentes type de requête entre la base de données et le frontend
 * @package Gestion scolaire
 * @subpackage EtudiantController
 */
class EtudiantController extends BaseController
{
    /**
     * Permet de récupérer les listes des etudiants qui sont limiter par le nombre de pagination
     * @param  \Illuminate\Http\Request
     ** @return \Illuminate\Http\Response retourne une liste d'etudiant avec ses matieres
     */
    public function index(Request $_srequest)
    {
        /*  variables qui stockent le type de filtre à faire */
        $sfilterType = $_srequest->input('type');
        $sfiltervalue = $_srequest->input('value');

        /*  variable qui stock le type de trie à faire soit par asc soit par desc */
        $ssortbyType = $_srequest->input('sortbyType');
        $ssortbyValue = $_srequest->input('sortbyValue');

        $iper_page = intVal($_srequest->input('per_page'));

        $toetudiantMatiiere = Etudiant::with('matieres');

        if ($sfilterType && $sfiltervalue)
        {
            $toetudiantMatiiere->where($sfilterType, 'LIKE', '%' . $sfiltervalue . '%');
        } else if ($ssortbyType && $ssortbyValue) {
            $toetudiantMatiiere->orderBy($ssortbyType, $ssortbyValue);
        }

        $toetudiant = $toetudiantMatiiere->paginate($iper_page);
        return $this->sendResponse($toetudiant, 'Etudiant retrieved successfully.');
    }
    /**
     * Enregistrement d'un etudiant dans la base de données
     *
     * @param  \Illuminate\Http\Request  $_srequest requête venant du côté front
     * @return \Illuminate\Http\Response retourne l'etudiant qui vient d'être enregistrer
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

        $oetudiant = Etudiant::create($tsinput);
        return $this->sendResponse(new EtudiantResource($oetudiant), 'Etudiant created successfully.');
    }

    /**
     * Permet de prendre un etudiant specifique
     *
     * @param  int  $iid parametre qui permet d'identifier un etudiant à récupérer
     * @return \Illuminate\Http\Response retourne un etudiant avec ses matieres
     */
    public function show($iid)
    {
        $oetudiant = Etudiant::find($iid);
        $tomatieres = Etudiant::find($iid)->matieres;

        if (is_null($oetudiant)) {
            return $this->sendError('Etudiant not found.');
        }

        return $this->sendResponse([$oetudiant, $tomatieres], 'Etudiant retrieved successfully.');
    }

    /**
     * Modification d'un etudiant dans la base de données
     *
     * @param  \Illuminate\Http\Request  $_srequest requete venant du côté front
     * @param  int  $iid parametre qui permet d'identifier l'etudiant à modifier
     * @return \Illuminate\Http\Response retourne l'etudiant qui vient d'être modifier
     */
    public function update(Request $_srequest, Etudiant $etudiant)
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

        $etudiant->name = $tsinput['name'];
        $etudiant->numero = $tsinput['numero'];
        $etudiant->sexe = $tsinput['sexe'];
        $etudiant->save();

        return $this->sendResponse(new EtudiantResource($etudiant), 'Etudiant updated successfully.');
    }

    /**
     * Suppression d'un etudiant dans la base de données
     *
     * @param  int  $iid parametre qui permet d'identifier l'etudiant à supprimer
     * @return \Illuminate\Http\Response retourne une message confirmant la suppression d'un étdiant
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return $this->sendResponse([], 'Etudiant deleted successfully.');
    }
}
