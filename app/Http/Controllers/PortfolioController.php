<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function create()
    {
        return view('company.portfolio.create');
    }

    public function store(Request $request)
    {
        // To be implemented
        return redirect()->back();
    }
}
