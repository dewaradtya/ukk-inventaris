<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['Level']);
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('level', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->paginate(10);
        $levels = Level::all();
        return view('pages/admin/management-user/index', compact('users', 'levels'));
    }

    public function create()
    {
        return view('pages/admin/management-user/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:5', 'max:20'],
            'name' => ['required', 'string', 'max:50'],
            'id_level' => ['required', 'exists:levels,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('img/users', 'public');
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'id_level' => $request->id_level,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('user-management.index')
            ->with('success', 'Management user berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $levels = Level::all();

        return view('pages.admin.management-user.edit', [
            'user' => $user,
            'levels' => $levels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:20', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:5', 'max:20'],
            'name' => ['required', 'string', 'max:50'],
            'id_level' => ['required', 'exists:levels,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $imagePath = $user->image;
        if ($request->hasFile('image')) {
            if ($user->image && \Storage::exists('public/' . $user->image)) {
                \Storage::delete('public/' . $user->image);
            }
            $imagePath = $request->file('image')->store('img/users', 'public');
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'name' => $request->name,
            'id_level' => $request->id_level,
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('user-management.index')
            ->with('success', 'Management user berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user-management.index')->with('success', 'Data berhasil dihapus!');
    }
}
