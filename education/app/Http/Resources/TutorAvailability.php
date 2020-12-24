<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class TutorAvailability extends Resource
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
            // tutor profile
            'tutor_profile_id'     => $this->tutor_profile_id,

            // timing
            'start_time'           => Carbon::parse($this->start_time)->format('g:i A'),
            'end_time'             => Carbon::parse($this->end_time)->format('g:i A'),
            // days
            'days'                 => [
                                        'SUN'                  => $this->SUN,
                                        'MON'                  => $this->MON,
                                        'TUE'                  => $this->TUE,
                                        'WED'                  => $this->WED,
                                        'THU'                  => $this->THU,
                                        'FRI'                  => $this->FRI,
                                        'SAT'                  => $this->SAT
                                       ],

            // admin
            'moderate_id'                  => $this->moderate_id,

            'created_at'             => (string) $this->created_at,
            'updated_at'             => (string) $this->updated_at
        ];
    }
}
