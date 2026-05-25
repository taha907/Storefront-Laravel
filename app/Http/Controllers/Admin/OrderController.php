<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    public function approve(Order $order)
    {
        try {
            $this->orderService->approve($order);
            return back()->with('success', 'Sipariş onaylandı.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function advance(Order $order)
    {
        try {
            $this->orderService->advanceStage($order);
            return back()->with('success', 'Sipariş aşaması ilerletildi.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateNote(Request $request, Order $order)
    {
        $order->update(['admin_note' => $request->admin_note]);

        return back()->with('success', 'Not güncellendi.');
    }
}
