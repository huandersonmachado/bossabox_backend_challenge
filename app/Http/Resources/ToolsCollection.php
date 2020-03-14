<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ToolsCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            $this->collection->map(function($tool) use ($request) {
                return (new ToolsResource($tool))->toArray($request);
            })
        ];
    }
}
