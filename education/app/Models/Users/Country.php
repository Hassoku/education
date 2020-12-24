<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_code',
    ];

    public function states()
    {
        return $this->hasMany(State::Class);
    }
}
