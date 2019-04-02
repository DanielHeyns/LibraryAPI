<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'name' => $this->name,
            'ISBN' => $this->ISBN,
            'pub_year'=>$this->pub_year,
            'pub'=>$this->pub,
            'image_path'=>$this->image_path,
            'author' => $this->author,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            // 'ratings' => $this->ratings,
            // 'average_rating' => $this->ratings->avg('rating'),
          ];
    }
}
