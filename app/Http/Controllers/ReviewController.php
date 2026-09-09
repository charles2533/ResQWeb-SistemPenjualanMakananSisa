<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'target_type' => 'required|in:application,store',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $order->loadMissing('food');

        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan memberi rating untuk pesanan ini.');
        }

        if ($order->status !== 'completed') {
            return back()->with('error', 'Rating hanya bisa dikirim setelah pesanan selesai di-pickup.');
        }

        Review::updateOrCreate(
            [
                'order_id' => $order->id,
                'customer_id' => Auth::id(),
                'target_type' => $validated['target_type'],
            ],
            [
                'target_user_id' => $validated['target_type'] === 'store'
                    ? $order->food->seller_id
                    : null,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return back()->with('success', 'Rating berhasil disimpan. Terima kasih atas masukannya.');
    }
}
