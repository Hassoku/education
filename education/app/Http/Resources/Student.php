<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Student extends Resource
{
    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }

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
            'stu_status'            => $this->status,
            'activated'             => (bool)$this->activated,
            'online_status'         => (bool)$this->online_status,
            'referral_code'         => $this->referral_code,
            'referral_link'         => route('student.invite.register.show',['ref_code' => $this->referral_code]),
            'profile'               => new StudentProfile($this->profile),
            'preferences'           => new StudentPreferences($this->preferences),
            'created_at'             => (string) $this->created_at,
            'updated_at'             => (string) $this->updated_at
        ];
    }
}
