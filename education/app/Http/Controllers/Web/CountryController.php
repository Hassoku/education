<?php

namespace App\Http\Controllers\Web;
use App\Models\Users\State;
use App\Models\Users\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function getStates(Country $country)
    {
        return $country->states()->select('id', 'name')->get();
    }
}
