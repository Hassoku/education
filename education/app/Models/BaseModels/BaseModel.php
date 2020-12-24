<?php

namespace App\Models\BaseModels;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $guarded = ['id'];
}