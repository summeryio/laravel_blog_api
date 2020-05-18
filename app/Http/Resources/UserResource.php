<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $showSensitiveFields = false;

    public function toArray($request)
    {
        if (!$this->showSensitiveFields) {
            $this->resource->addHidden(['phone']);
        }

        return parent::toArray($request);
    }

    public function showSensitiveFields() {
        $this->showSensitiveFields = true;

        return $this;
    }
}
