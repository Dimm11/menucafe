<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Import the View class

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index(): View // Specify that it returns a View
    {
        return view('welcome'); // Return the 'welcome' view (default Laravel welcome page)
    }
}