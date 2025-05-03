<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $unassignedAdmins = User::where('role', 'admin')
            ->where('id', '!=', auth()->id())
            ->get();
        if (auth()->user()->role === 'super-admin') {
            $admins = User::whereIn('role', ['admin', 'tester'])->latest()->get();
        } else {
            $admins = User::where('role', 'admin')
                ->latest()
                ->get();
        }

        return view('admins.index', compact('admins', 'unassignedAdmins'));
    }


    // Show form to create new admin
    public function create()
    {
        $unassignedAdmins = User::where('role', 'admin')
            ->where('id', '!=', auth()->id())
            ->get();
        return view('admins.create', compact('unassignedAdmins'));
    }

    // Store new admin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',
            'user_assigned_by' => 'nullable|array',
        ]);

        $admin = ($request->tester === 'on') ? 'tester' : 'admin';

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $admin,
            'password' => Hash::make($validated['password']),
            'assigned_admins' => isset($validated['user_assigned_by']) ? implode(',', $validated['user_assigned_by']) : null,
        ]);

        return redirect()->route('admins.index')->with('success', 'Admin created successfully.');
    }


    // Show edit form
    public function edit($id)
    {
        $unassignedAdmins = User::where('role', 'admin')
            ->where('id', '!=', auth()->id())
            ->get();
        $admin = User::findOrFail($id);
        return view('admins.edit', compact('admin','unassignedAdmins'));
    }

    // Update admin
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'user_assigned_by' => 'nullable|array',

        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        
        $admin->role = $request->tester === 'on' ? 'tester' : 'admin';
        $admin->assigned_admins = isset($validated['user_assigned_by']) ? implode(',', $validated['user_assigned_by']) : null;
        
        $admin->save();
        return redirect()->route('admins.index')->with('success', 'Admin updated successfully.');
    }

    // Delete admin
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully.');
    }

    public function assignUser($id)
    {
        $admin = User::findOrFail($id);
        if (!$admin->user_assigned_by) {
            $admin->user_assigned_by = auth()->id();
            $admin->save();

            return back()->with('success', 'User assigned successfully.');
        }

        return back()->with('success', 'User already assigned.');
    }

    public function bulkAssign(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        User::whereIn('id', $request->user_ids)
            ->update(['user_assigned_by' => auth()->id()]);

        return redirect()->back()->with('success', 'Users assigned successfully.');
    }
}
