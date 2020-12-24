<?php

namespace App\Http\Resources;

use App\Http\Resources\TutorProfile as TutorProfileResource;
use Illuminate\Http\Resources\Json\Resource;

class Tutor extends Resource
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
            'name'                  => $this->name, // first name
            'middle_name'           => ($this->middle_name == null) ? "" : $this->middle_name , // middle_name
            'last_name'             => $this->last_name, // last_name
            'mobile'                => $this->mobile,
            'email'                 => $this->email,
            'active'                => (bool)$this->active,
            'online_status'         => (bool)$this->online_status,
            'isBusy'                => (bool)$this->isBusy,
            'profile'               => new TutorProfileResource($this->profile),
            'created_at'            => (string) $this->created_at,
            'updated_at'            => (string) $this->updated_at
        ];
    }
}
