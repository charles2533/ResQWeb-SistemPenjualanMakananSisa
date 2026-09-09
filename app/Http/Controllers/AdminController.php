<?php

namespace App\Http\Controllers;

use App\Models\SellerWithdrawal;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Menghitung statistik untuk ekosistem
        $totalSellers = User::where('role', 'seller')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        
        // Makanan diselamatkan (berdasarkan pesanan yang sudah 'completed')
        $foodRescued = Order::where('status', 'completed')->sum('quantity');
        
        // Estimasi perputaran uang di platform
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $customerAdminRevenue = Order::where('status', 'completed')->sum('admin_fee');
        $sellerCommissionRevenue = SellerWithdrawal::sum('commission_amount');
        $platformRevenue = $customerAdminRevenue + $sellerCommissionRevenue;

        $ratingAverages = Review::selectRaw('target_type, AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->groupBy('target_type')
            ->get()
            ->keyBy('target_type');

        // Mengambil 10 transaksi terakhir dari seluruh platform
        $recentOrders = Order::with(['food.seller', 'customer'])
                            ->latest()
                            ->limit(10)
                            ->get();

        return view('admin.dashboard', compact(
            'totalSellers', 
            'totalCustomers', 
            'foodRescued', 
            'totalRevenue', 
            'customerAdminRevenue',
            'sellerCommissionRevenue',
            'platformRevenue',
            'ratingAverages',
            'recentOrders'
        ));
    }
}
