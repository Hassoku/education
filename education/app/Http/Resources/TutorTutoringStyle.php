<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;


class TutorTutoringStyle extends Resource
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
            'tutoring_style' =>   $this->tutoring_style->tutoring_style
        ];
    }
}
