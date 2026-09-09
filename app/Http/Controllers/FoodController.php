<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Food;
use App\Models\Order;
use App\Models\Review;
use App\Models\SellerWithdrawal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FoodController extends Controller
{
    // Menampilkan Dashboard Seller (Keuangan dan Withdraw)
    public function sellerDashboard()
    {
        $seller = Auth::user()->fresh();

        $completedOrders = Order::with(['food', 'customer'])
            ->where('status', 'completed')
            ->whereHas('food', fn ($query) => $query->where('seller_id', $seller->id))
            ->latest()
            ->get();

        $stats = [
            'available_balance' => $seller->seller_balance,
            'gross_sales' => $seller->seller_total_earned,
            'net_withdrawn' => $seller->seller_total_withdrawn,
            'commission_paid' => $seller->seller_total_commission_paid,
            'completed_orders' => $completedOrders->count(),
            'pending_orders' => Order::where('status', 'pending')
                ->whereHas('food', fn ($query) => $query->where('seller_id', $seller->id))
                ->count(),
        ];

        $withdrawCommissionRate = (float) config('resq.seller_withdraw_commission_percentage', 10);
        $estimatedCommission = $stats['available_balance'] * ($withdrawCommissionRate / 100);
        $estimatedNet = max($stats['available_balance'] - $estimatedCommission, 0);

        $recentOrders = $completedOrders->take(5);
        $withdrawals = SellerWithdrawal::where('seller_id', $seller->id)->latest('processed_at')->limit(10)->get();

        return view('seller.dashboard', compact(
            'seller',
            'stats',
            'withdrawCommissionRate',
            'estimatedCommission',
            'estimatedNet',
            'recentOrders',
            'withdrawals',
        ));
    }

    // Menampilkan halaman stok seller
    public function inventory()
    {
        $foods = Food::where('seller_id', Auth::id())->latest()->get();

        return view('seller.inventory', compact('foods'));
    }

    public function donations()
    {
        $donations = Donation::where('seller_id', Auth::id())->latest()->get();

        return view('seller.donations.index', compact('donations'));
    }

    public function createDonation()
    {
        return view('seller.donations.create');
    }

    // Menampilkan Form Tambah Makanan
    public function create()
    {
        return view('seller.food.create');
    }

    // Menyimpan Data Makanan ke Database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'pickup_time_start' => 'required|date_format:H:i',
            'pickup_time_end' => 'required|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar max 2MB
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $validated['seller_id'] = Auth::id();
        $validated['status'] = 'available';

        Food::create($validated);

        return redirect()->route('seller.inventory')->with('success', 'Sisa makanan berhasil diunggah!');
    }

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('donations', 'public');
        }

        $validated['seller_id'] = Auth::id();
        $validated['status'] = 'available';

        Donation::create($validated);

        return redirect()->route('seller.donations')->with('success', 'Donasi untuk bank makanan berhasil ditambahkan.');
    }
    // Menampilkan Katalog Makanan untuk Customer (Agus)
    public function index()
    {
        // Ambil semua makanan yang stoknya > 0 dan status available
        // 'with('seller')' digunakan untuk memanggil data relasi penjualnya
        $foods = Food::with('seller')
                    ->where('stock', '>', 0)
                    ->where('status', 'available')
                    ->latest()
                    ->get();

        $sellerRatings = Review::selectRaw('target_user_id, target_type, AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->where('target_type', 'store')
            ->whereIn('target_user_id', $foods->pluck('seller_id')->unique())
            ->groupBy('target_user_id', 'target_type')
            ->get()
            ->groupBy('target_user_id');

        foreach ($foods as $food) {
            $ratingGroup = $sellerRatings->get($food->seller_id, collect())->keyBy('target_type');
            $food->store_avg_rating = optional($ratingGroup->get('store'))->avg_rating;
            $food->store_rating_count = optional($ratingGroup->get('store'))->total_reviews ?? 0;
        }

        return view('customer.katalog', compact('foods'));
    }

    // Menampilkan Profil Toko Publik untuk Customer
    public function storeProfile($id)
    {
        $seller = User::where('role', 'seller')->findOrFail($id);
        
        // Ambil semua makanan yang tersedia di toko ini
        $foods = Food::where('seller_id', $id)
                    ->where('stock', '>', 0)
                    ->where('status', 'available')
                    ->latest()
                    ->get();

        $ratingSummary = Review::selectRaw('target_type, AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->where('target_user_id', $id)
            ->where('target_type', 'store')
            ->groupBy('target_type')
            ->get()
            ->keyBy('target_type');

        return view('customer.store', compact('seller', 'foods', 'ratingSummary'));
    }

public function destroy($id)
{
    // Cari makanan berdasarkan ID dan pastikan itu milik penjual yang sedang login
    $food = Food::where('id', $id)->where('seller_id', auth()->id())->firstOrFail();
    
    // Hapus file foto jika ada (Opsional tapi disarankan agar storage tidak penuh)
    if ($food->image) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($food->image);
    }

    $food->delete();

    return redirect()->back()->with('success', 'Menu makanan berhasil dihapus dari katalog!');
}

    public function destroyDonation($id)
    {
        $donation = Donation::where('id', $id)->where('seller_id', Auth::id())->firstOrFail();

        if ($donation->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($donation->image);
        }

        $donation->delete();

        return redirect()->back()->with('success', 'Data donasi berhasil dihapus.');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $commissionRate = (float) config('resq.seller_withdraw_commission_percentage', 10);
        $requestedAmount = (float) $request->amount;

        DB::transaction(function () use ($requestedAmount, $commissionRate) {
            $seller = User::whereKey(Auth::id())->lockForUpdate()->firstOrFail();

            if ($requestedAmount > $seller->seller_balance) {
                throw ValidationException::withMessages([
                    'amount' => 'Saldo seller tidak mencukupi untuk nominal withdraw tersebut.',
                ]);
            }

            $commissionAmount = round($requestedAmount * ($commissionRate / 100), 2);
            $netAmount = $requestedAmount - $commissionAmount;

            if ($netAmount <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Nominal withdraw tidak valid setelah komisi dihitung.',
                ]);
            }

            $seller->decrement('seller_balance', $requestedAmount);
            $seller->increment('seller_total_withdrawn', $netAmount);
            $seller->increment('seller_total_commission_paid', $commissionAmount);

            SellerWithdrawal::create([
                'seller_id' => $seller->id,
                'gross_amount' => $requestedAmount,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'net_amount' => $netAmount,
                'processed_at' => now(),
            ]);
        });

        return back()->with('success', 'Withdraw berhasil diproses. Saldo seller sudah dikurangi beserta komisi platform.');
    }
}
