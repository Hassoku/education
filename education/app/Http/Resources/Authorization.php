<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Authorization extends Resource
{
    public function with($request)
    {
        return [
            'status' => 'success',
            'student' => new Student($this->student()),
            'remaining' => $this->remaining(),
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
            'token' => $this->getToken(),
            'expired_at' => $this->getExpiredAt(),
            'refresh_expired_at' => $this->getRefreshExpiredAt()
        ];

    }
}
