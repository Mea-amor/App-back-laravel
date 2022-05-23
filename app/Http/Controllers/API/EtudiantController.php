<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Etudiant;
use Validator;
use App\Http\Resources\Etudiant as EtudiantResource;

class EtudiantController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $etudiantM = Etudiant::with('matieres');
        $input = intVal($request->all()["per_page"]);

        $etudiant = $etudiantM->paginate($input);
        return $this->sendResponse($etudiant, 'Etudiant retrieved successfully.');
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
            'name' => 'required',
            'numero' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $etudiant = Etudiant::create($input);

        return $this->sendResponse(new EtudiantResource($etudiant), 'Etudiant created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $etudiant = Etudiant::find($id);

        if (is_null($etudiant)) {
            return $this->sendError('Etudiant not found.');
        }

        return $this->sendResponse(new EtudiantResource($etudiant), 'Etudiant retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'numero' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $etudiant->name = $input['name'];
        $etudiant->numero = $input['numero'];
        $etudiant->sexe = $input['sexe'];
        $etudiant->save();

        return $this->sendResponse(new EtudiantResource($etudiant), 'Etudiant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();

        return $this->sendResponse([], 'Etudiant deleted successfully.');
    }
}
