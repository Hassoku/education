<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;


class TutorSpecialization extends Resource
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
//            'specialization' =>   $this->specialization->specialization
            'topic'                 => $this->topic->topic,
            'topic_id'              => $this->topic->id
        ];
    }
}
