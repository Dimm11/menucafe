<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash; // Import Hash facade

class StaffUserController extends Controller
{
    /**
     * Display a listing of staff users.
     */
    public function index(): View
    {
        $staffUsers = Staff::latest()->get(); // Fetch all staff users, newest first

        return view('staff.users.index', ['staffUsers' => $staffUsers]); // Pass staff users to the index view
    }

    /**
     * Show the form for creating a new staff user.
     */
    public function create(): View
    {
        return view('staff.users.create'); // Show create form
    }

    /**
     * Store a newly created staff user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([ // Validate input data
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email|max:255', // Unique in 'staff' table, 'email' column
            'password' => 'required|min:8|confirmed', // 'confirmed' rule checks for password_confirmation field
        ]);

        Staff::create([ // Create new Staff user
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hash the password before storing
        ]);

        return redirect()->route('staff.users.index')->with('success', 'Staff user created successfully!'); // Redirect to staff list with success message
    }

    /**
     * Show the form for editing the specified staff user.
     */
    public function edit(Staff $staff): View // Route Model Binding - $staff is the Staff model instance
    {
        return view('staff.users.edit', ['staff' => $staff]); // Pass staff user to edit view
    }

    /**
     * Update the specified staff user in storage.
     */
    public function update(Request $request, Staff $staff): RedirectResponse // Route Model Binding for $staff
    {
        $validatedData = $request->validate([ // Validate input data for update
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id . '|max:255', // Unique except for current user being edited
            'password' => 'nullable|min:8|confirmed', // Password is optional for update, but must be confirmed if provided
        ]);

        $staff->name = $validatedData['name']; // Update name and email
        $staff->email = $validatedData['email'];

        if ($validatedData['password']) { // Only update password if a new password is provided
            $staff->password = Hash::make($validatedData['password']); // Hash new password
        }

        $staff->save(); // Save updated staff user

        return redirect()->route('staff.users.index')->with('success', 'Staff user updated successfully!'); // Redirect with success message
    }

    /**
     * Remove the specified staff user from storage.
     */
    public function destroy(Staff $staff): RedirectResponse // Route Model Binding for $staff
    {
        $staff->delete(); // Delete the staff user

        return redirect()->route('staff.users.index')->with('success', 'Staff user deleted successfully!'); // Redirect with success message
    }
}