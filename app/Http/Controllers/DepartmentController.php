<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class DepartmentController extends Controller
{
    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department = Department::create([
            'name' => $request->input('name'),
        ]);
        $user = Auth::user();

    // Check if user is properly retrieved and update department_id
        if ($user) {
            $user->department_id = $department->id;
            $user->save();
        } else {
            // Handle the case where no user is authenticated
            return redirect()->route('dashboard')->with('error', 'User not authenticated.');
        }


        return redirect()->route('dashboard')->with('success', 'Department created successfully.');
    }
}
