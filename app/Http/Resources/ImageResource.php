<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Resources\Json\JsonResource;
 
class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (str_contains($this->url, 'http') === true) {
            $url = $this->url;
        } else {
            $url = env('IMAGE_URL') . $this->url;
        }

        return [
            'id' => $this->id,
            'url' => $url,
            'thumb' => new ImageThumbnailResource($this->imageThumbnail)
        ];
    }
}