<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Proses pembuatan pesanan
    public function store(Request $request, $food_id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'accepted_order_terms' => 'accepted',
        ]);

        $food = Food::findOrFail($food_id);
        $quantity = $request->quantity;
        $subtotal = $food->discount_price * $quantity;
        $adminFee = (float) config('resq.customer_admin_fee', 1000);
        $totalPrice = $subtotal + $adminFee;

        // Cek apakah stok mencukupi
        if ($food->stock < $quantity) {
            return back()->with('error', 'Maaf, pesanan gagal. Stok makanan tidak mencukupi.');
        }

        // Gunakan DB Transaction agar data aman. Jika di tengah jalan error, semua dibatalkan (rollback).
        DB::transaction(function () use ($food, $quantity, $subtotal, $adminFee, $totalPrice) {
            // 1. Catat Pesanan ke tabel orders
            Order::create([
                'customer_id' => Auth::id(),
                'food_id' => $food->id,
                'quantity' => $quantity,
                'subtotal_price' => $subtotal,
                'admin_fee' => $adminFee,
                'total_price' => $totalPrice,
                'status' => 'pending', // Status pending (menunggu diambil/dibayar di tempat)
            ]);

            // 2. Kurangi stok makanan di tabel foods
            $food->decrement('stock', $quantity);

            // 3. Jika stok habis, ubah status makanan jadi sold_out
            if ($food->stock == 0) {
                $food->update(['status' => 'sold_out']);
            }
        });

        // Arahkan ke halaman riwayat pesanan dengan pesan sukses
        return redirect()->route('order.history')->with('success', 'Pesanan berhasil dibuat. Silakan ambil sesuai jadwal pickup. Total sudah termasuk biaya admin platform.');
    }

    // Menampilkan halaman Riwayat Pesanan untuk Customer
    public function myOrders()
    {
        // Ambil data order beserta relasi makanan dan nama penjualnya
        $orders = Order::with(['food', 'food.seller'])
                    ->where('customer_id', Auth::id())
                    ->latest()
                    ->get();

        $reviews = Review::where('customer_id', Auth::id())
            ->whereIn('order_id', $orders->pluck('id'))
            ->get()
            ->groupBy('order_id')
            ->map(fn ($items) => $items->mapWithKeys(fn ($review) => [
                $review->target_type => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                ],
            ])->all());

        return view('customer.orders', compact('orders', 'reviews'));
    }
    // Menampilkan daftar pesanan masuk untuk Seller (Pak Budi)
    public function sellerOrders()
    {
        // Ambil orderan yang makanannya adalah milik seller yang sedang login
        $orders = Order::with(['food', 'customer'])
            ->whereHas('food', function ($query) {
                $query->where('seller_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('seller.orders', compact('orders'));
    }
    // Fungsi untuk menandai pesanan telah selesai/diambil
    public function complete($id)
    {
        $order = Order::with('food')->findOrFail($id);

        // Keamanan: Pastikan yang mengubah adalah pemilik makanan (Pak Budi)
        if ($order->food->seller_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan melakukan aksi ini.');
        }

        if ($order->status === 'completed') {
            return back()->with('success', 'Pesanan ini sudah lebih dulu ditandai selesai.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'completed']);

            $seller = $order->food->seller()->lockForUpdate()->firstOrFail();
            $seller->increment('seller_balance', $order->subtotal_price);
            $seller->increment('seller_total_earned', $order->subtotal_price);
        });

        return back()->with('success', 'Pesanan berhasil diselesaikan. Nilai pesanan sudah masuk ke saldo seller.');
    }
}
