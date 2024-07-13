<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RedeemHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'partner_name' => $this->name,
            'partner_description' => $this->description,
            'points_payed' => $this->points_paid
        ];
        return parent::toArray($request);
    }
}
