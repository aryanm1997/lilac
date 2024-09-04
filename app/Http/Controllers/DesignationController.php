<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $designation = Designation::create([
            'name' => $request->input('name'),
        ]);
    
        // Retrieve the authenticated user
        $user = Auth::user();
    
        // Check if user is properly retrieved and update designation_id
        if ($user) {
            $user->designation_id = $designation->id;
            $user->save();
        } else {
            // Handle the case where no user is authenticated
            return redirect()->route('dashboard')->with('error', 'User not authenticated.');
        }

        return redirect()->route('dashboard')->with('success', 'Designation created successfully.');
    }
}
