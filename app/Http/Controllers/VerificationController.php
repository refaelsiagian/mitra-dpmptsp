<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function store(Request $request)
    {
        // Dump the incoming data to verify the form submission is correct
        dd($request->all());
    }
}
