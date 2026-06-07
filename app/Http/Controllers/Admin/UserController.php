<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->isAdmin()) {
            abort(404);
        }

        $user->load(['orders', 'balanceTransactions']);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->isAdmin()) {
            abort(404);
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->isAdmin()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı güncellendi.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            abort(403);
        }

        $user->delete();

        return back()->with('success', 'Kullanıcı silindi.');
    }

    public function freeze(User $user)
    {
        if ($user->isAdmin()) {
            abort(403);
        }

        $user->update(['is_active' => false]);

        return back()->with('success', 'Hesap donduruldu.');
    }

    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        return back()->with('success', 'Hesap aktifleştirildi.');
    }
}
