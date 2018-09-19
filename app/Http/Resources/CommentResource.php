<?php

namespace App\Http\Resources;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'body' => $this->body,
            'children' => CommentResource::collection(
                $this->whenLoaded('children')
            ),
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
