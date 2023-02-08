<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
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
