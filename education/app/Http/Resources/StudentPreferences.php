<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Carbon;


class StudentPreferences extends Resource
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
            //'id'                    => $this->id,
            //"student_id"              => $this->student_id,
            'language'               => $this->language,
            'timezone'               => $this->timezone,
            'desktopNotification'    => (bool) $this->desktopNotification,
            'emailNotification'      => (bool) $this->emailNotification,
            //'created_at'            => (string) $this->created_at,
            //'updated_at'            => (string) $this->updated_at,
        ];
    }
}
