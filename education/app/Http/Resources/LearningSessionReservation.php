<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Tutor as TutorResource;

class LearningSessionReservation extends Resource
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
            'student_id'            => $this->student_id,
            'tutor_id'              => $this->tutor_id,
            'topic'                 => $this->topic->topic,
            'date'                  => $this->date,
            'duration'              => $this->duration,
            'start_time'            => date('g:i A',strtotime($this->start_time)),
            'end_time'              => date('g:i A',strtotime($this->end_time)),
            'tutor'                 => new TutorResource($this->tutor)
        ];
    }
}
