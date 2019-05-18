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
        //  get current user
        $user = $this->user;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'cover_img' => '/storage/cover_images/'.$this->cover_img,
            'book' => '/storage/books/'.$this->book,
            'average_rating' => $this->ratings->avg('rating'),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'user' => $user,
            'ratings' => $this->ratings,
          ];
    }

    public function with($request)
    {
        // adding links
        return [
            'links'=> [
                'self'=> 'http://127.0.0.1:8000/books/'.$this->id,
                'all'=> 'http://127.0.0.1:8000/books'
            ],
            'version' => '1.0.0'
        ];
    }
}
