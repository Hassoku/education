<?php

namespace App\Models\BaseModels;


use Illuminate\Foundation\Auth\User as Authenticatable;

class BaseUserModel extends Authenticatable
{
    protected $guarded = ['id'];
}