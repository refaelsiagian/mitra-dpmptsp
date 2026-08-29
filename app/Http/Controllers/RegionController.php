<?php

namespace App\Http\Controllers;

use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class RegionController extends Controller
{
    public function regencies($province_id)
    {
        return Regency::where('province_id', $province_id)->orderBy('name')->get();
    }

    public function districts($regency_id)
    {
        return District::where('regency_id', $regency_id)->orderBy('name')->get();
    }

    public function villages($district_id)
    {
        return Village::where('district_id', $district_id)->orderBy('name')->get();
    }
}
