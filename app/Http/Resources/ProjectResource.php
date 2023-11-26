<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => new TypeResource($this->type),
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'repositories' => RepositoryResource::collection($this->repositories),
            'technologies' => TechnologyResource::collection($this->technologies),
            'images' => ImageResource::collection($this->images)
        ];
    }
}
