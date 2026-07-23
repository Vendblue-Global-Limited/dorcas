<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;


class ProductResource extends JsonResource {

public function toArray(Request $request) {
    return [
        'id' => $this->id,
        "name" => this->name,
        "description" => $this->description,
        "owner" => [
            "id"=> $this->owner?->id,
            "name" => $this->owner?->name,
        ],
        "created_at"=> $this->created_at,
        "updated_at" => $this->updated_at
    ]
}
}
