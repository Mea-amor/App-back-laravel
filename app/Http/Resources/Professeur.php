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
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'name' => $this->name,
            'categorie' => $this->categorie
            // 'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
