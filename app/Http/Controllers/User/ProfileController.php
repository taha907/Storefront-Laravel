<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\BalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(BalanceService $balanceService)
    {
        $user = auth()->user();
        $balance = $balanceService->getBalance($user);
        $transactions = Schema::hasTable('user_balances')
            ? $user->balanceTransactions()->latest()->take(20)->get()
            : collect();

        return view('user.profile.show', compact('user', 'balance', 'transactions'));
    }

    public function edit()
    {
        return view('user.profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $user->update($data);

        return back()->with('success', 'Profil bilgileriniz güncellendi.');
    }

    public function passwordForm()
    {
        return view('user.profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mevcut şifre hatalı.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Şifreniz güncellendi.');
    }

    public function deactivate(Request $request)
    {
        $request->validate(['confirm' => 'required|accepted']);

        $user = auth()->user();
        $user->update(['is_active' => false]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Üyeliğiniz pasif edildi.');
    }
}
