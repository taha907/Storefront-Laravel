<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('user.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $this->orderService->cancelByUser($order);
            return back()->with('success', 'Sipariş iptal edildi. Tutar hesap bakiyenize iade edildi.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirmReceipt(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $this->orderService->confirmReceipt($order);
            return back()->with('success', 'Teslim alındı olarak işaretlendi.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
