<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

public function index()
{
    $users = User::where('role', '!=', 'admin')->get(); // Jangan tampilkan admin
    return view('admin.users.index', compact('users'));
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
}

}
