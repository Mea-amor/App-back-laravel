<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Matiere;
use Validator;
use App\Http\Resources\Matiere as MatiereResource;
use App\Models\Etudiant;

class MatiereController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterType = $request->input('type');
        $filtervalue = $request->input('value');

        $sortbyType = $request->input('sortbyType');
        $sortbyValue = $request->input('sortbyValue');

        $per_page = intVal($request->input('per_page'));

        $matiereProf = Matiere::with('professeur');

        if ($filterType && $filtervalue) {
            $matiereProf->where($filterType, 'LIKE', '%' . $filtervalue . '%');
        } else if ($sortbyType && $sortbyValue) {
            $matiereProf->orderBy($sortbyType, $sortbyValue);
        }

        $matiere = $matiereProf->paginate($per_page);

        return $this->sendResponse($matiere, 'matiere retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'libelle' => 'required',
            'numero' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $matiere = Matiere::create($input);

        return $this->sendResponse(new MatiereResource($matiere), 'Matiere created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matiere = Matiere::find($id);

        if (is_null($matiere)) {
            return $this->sendError('Matiere not found.');
        }

        return $this->sendResponse(new MatiereResource($matiere), 'Matiere retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matiere $matiere)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'libelle' => 'required',
            'numero' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $profId = $request->input('professeur_id');
        $etudiantId = $request->input('etudiant_id');
        $isAddrelation = $request->input('remove');

        var_dump($isAddrelation);
        if ($profId) {
            $matiere->professeur_id = $profId;
        } else {
            $matiere->professeur_id = null;
        }
        $matiere->libelle = $input['libelle'];
        $matiere->numero = $input['numero'];
        $matiere->coefficient = $input['coefficient'];

        if ($etudiantId and $isAddrelation) {
            $etudiant = Etudiant::find($etudiantId);
            $matiere->etudiants()->sync($etudiant, false);
        } else {
            $etudiant = Etudiant::find($etudiantId);
            $matiere->etudiants()->detach($etudiant);
        }
        $matiere->save();

        return $this->sendResponse(new MatiereResource($matiere), 'Matiere updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matiere $matiere)
    {
        $matiere->delete();

        return $this->sendResponse([], 'Matiere deleted successfully.');
    }
}
