<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('profile.dashboard', [
            'events' => auth()->user()->events()->get(),
            'attending' => auth()->user()->attendingEvents()->get(),
        ]);
    }
}
