<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    /**
     * Show the staff dashboard.
     */
    public function index(): View
    {
        return view('staff.dashboard'); // Create staff dashboard view in next step
    }
}