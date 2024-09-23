<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function index(Request $request)
    {
        
    $search = $request->input('search');

    $users = Userdata::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('username', 'like', "%{$search}%")
                     ->orWhere('level', 'like', "%{$search}%");
    })->paginate(10);

    return view('userdata.index', compact('users'));

    }

    public function create()
    {
        return view('userdata.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255|unique:userdata,name',
            'username' => 'nullable|string|max:255|unique:userdata,username',
            'level' => 'required|in:admin,dokter,apoteker,pasien',
            'password' => 'nullable|string|min:6',
        ]);
        
        UserData::create([
            'name' => $request->name,
            'username' => $request->username,
            'level' => $request->level,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('userdata.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $userData = Userdata::findOrFail($id);
        return view('userdata.show', compact('userData'));
    }

    public function edit($id)
    {
        $userData = Userdata::findOrFail($id);
        return view('userdata.edit', compact('userData'));
    }

    public function update(Request $request, $id)
    {
        $userData = Userdata::findOrFail($id);
        $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'level' => 'required|in:admin,dokter,apoteker,pasien',
            'password' => 'nullable|string|min:6',
        ]);

        $userData->update([
            'name' => $request->name,
            'username' => $request->username,
            'level' => $request->level,
            'password' => $request->password ? bcrypt($request->password) : $userData->password,
        ]);

        return redirect()->route('userdata.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $userData = Userdata::findOrFail($id);
        $userData->delete();
        return redirect()->route('userdata.index')->with('success', 'User deleted successfully.');
    }
}
