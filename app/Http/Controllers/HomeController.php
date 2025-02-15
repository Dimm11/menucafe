<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Import the View class

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index(Request $request): View // Specify that it returns a View
    {
        $tableId = $request->query('table');
        return view('welcome', ['tableId' => $tableId]); // Return the 'welcome' view (default Laravel welcome page)
    }
}