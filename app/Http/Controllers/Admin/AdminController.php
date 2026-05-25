<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Enums\OrderStatus;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::where('role', 'user')->count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'pending_orders' => Order::where('status', OrderStatus::Pending->value)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    public function profile()
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($data);

        return back()->with('success', 'Profil güncellendi.');
    }

    public function updatePassword(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return back()->with('success', 'Şifre güncellendi.');
    }
}
