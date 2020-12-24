<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Topic extends Resource
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
            'id'                    => $this->id,
            'topic'                 => $this->topic,
            'description'           => $this->description,
            'parent'                => $this->parent,
            'level'                 => $this->level,
            'status'                 => $this->status,
/*            'created_at'            => (string) $this->created_at,
            'updated_at'            => (string) $this->updated_at*/
        ];
    }
}
