<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Etudiant extends JsonResource
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
            'img' => $this->img,
            'numero' => $this->numero,
            'name' => $this->name,
            'sexe' => $this->sexe
            // 'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
