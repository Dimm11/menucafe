<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StaffAuthController extends Controller
{
    /**
     * Show the staff login form.
     */
    public function showLoginForm(): View|RedirectResponse // Update return type to allow RedirectResponse
    {
        if (Auth::guard('staff')->check()) { // Check if staff is already logged in
            return redirect()->route('staff.dashboard'); // Redirect to dashboard if already logged in
        }

        return view('staff.auth.login'); // Show login form if not logged in
    }

    /**
     * Handle staff login submission.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([ // Validate login data
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('staff')->attempt($credentials, $request->boolean('remember'))) { // Attempt login with 'staff' guard
            $request->session()->regenerate(); // Regenerate session ID for security
            return redirect()->intended(route('staff.dashboard')); // Redirect to staff dashboard after login
        }

        return back()->withErrors([ // If login fails, return back with errors
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the staff member out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('staff')->logout(); // Logout using 'staff' guard

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->route('home'); // Redirect to homepage after logout
    }
}