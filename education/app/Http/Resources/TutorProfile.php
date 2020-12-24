<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Carbon;


class TutorProfile extends Resource
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
            "tutor_id"              => $this->tutor_id,
            "picture"               => asset($this->picture) == asset("") ? "" : asset($this->picture),
            "video"                 => asset($this->video) == asset("") ? "" : asset($this->video),
            "education"             => $this->education,
            "tutor_languages"       => TutorLanguage::collection($this->tutor_languages),
            "tutor_specializations" => TutorSpecialization::collection($this->tutor_specializations),
            "tutor_tutoring_styles" => TutorTutoringStyle::collection($this->tutor_tutoring_styles),
            "tutor_interests"       => TutorInterest::collection($this->tutor_interests),
            "tutor_certifications"  => TutorCertification::collection($this->tutor_certifications),
            "rating"                => $this->rating(),//['total_rating' => $this->rating()["total_rating"], 'rated_by' => $this->rating()["total_raters"]],
            "tutor_availabilities"  => TutorAvailability::collection($this->tutor_availabilities),
            "tutor_availability_dates"  => $this->tutor_availability_dates(),
            'created_at'            => (string) $this->created_at,
            'updated_at'            => (string) $this->updated_at,
        ];
    }
}
