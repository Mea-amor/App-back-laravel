<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Professeur;
use Validator;
use App\Http\Resources\Professeur as ProfesseurResource;

class ProfesseurController extends BaseController
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

        $professeurMat = Professeur::with('matieres');

        if ($filterType && $filtervalue) {
            $professeurMat->where($filterType, 'LIKE', '%' . $filtervalue . '%');
        } else if ($sortbyType && $sortbyValue) {
            $professeurMat->orderBy($sortbyType, $sortbyValue);
        }

        $professeur = $professeurMat->paginate($per_page);

        return $this->sendResponse($professeur, 'Professeur retrieved successfully.');
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

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $professeur = Professeur::create($input);

        return $this->sendResponse(new ProfesseurResource($professeur), 'Professeur created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $professeur = Professeur::find($id);

        if (is_null($professeur)) {
            return $this->sendError('Professeur not found.');
        }

        return $this->sendResponse(new ProfesseurResource($professeur), 'Professeur retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professeur $professeur)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'numero' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $professeur->name = $input['name'];
        $professeur->numero = $input['numero'];
        $professeur->categorie = $input['categorie'];
        $professeur->save();

        return $this->sendResponse(new ProfesseurResource($professeur), 'Professeur updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professeur $professeur)
    {
        $professeur->delete();

        return $this->sendResponse([], 'Professeur deleted successfully.');
    }
}
