<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Matiere extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            $professeur=$this->whenLoaded('professeur');
           return [
            'id' => $this->id,
            'numero' => $this->numero,
            'libelle' => $this->libelle,
            'coefficient' => $this->coefficient,
            'professeur'=>new Professeur($professeur)

        ];

        // return parent::toArray($request);
    }
}
