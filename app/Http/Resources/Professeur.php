<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Professeur extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
          $matieres=$this->whenLoaded('matieres');
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'name' => $this->name,
            'categorie' => $this->categorie,
            'matieres'=>Matiere::collection($matieres)

        ];
    }
}
