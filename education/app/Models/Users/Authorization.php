<?php

namespace App\Models\Users;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authorization
{
    protected $token;
    protected $payload;
    private $remaining;
    
    public function __construct($token = null, $remaining = null)
    {
        $this->token = $token;
        $this->remaining = $remaining;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function getToken()
    {
        if (! $this->token) {
            throw new \Exception('Please set token');
        }

        return $this->token;
    }

    public function getPayload()
    {
        if (!$this->payload) {
            $this->payload = JWTAuth::setToken($this->getToken())->getPayload();
        }

        return $this->payload;
    }

    public function getExpiredAt()
    {
        return Carbon::createFromTimestamp($this->getPayload()->get('exp'))
            ->toDateTimeString();
    }

    public function getRefreshExpiredAt()
    {
        return Carbon::createFromTimestamp($this->getPayload()->get('iat'))
            ->addMinutes(config('jwt.refresh_ttl'))
            ->toDateTimeString();
    }

    public function student()
    {
        try {
            return JWTAuth::authenticate($this->getToken()); // return the user
        } catch (\Exception $e) {
        }
    }
    public function remaining()
    {
        return $this->remaining;
    }

    public function toArray()
    {
        return [
            'token' => $this->getToken(),
            'expired_at' => $this->getExpiredAt(),
            'refresh_expired_at' => $this->getRefreshExpiredAt(),
        ];
    }
}