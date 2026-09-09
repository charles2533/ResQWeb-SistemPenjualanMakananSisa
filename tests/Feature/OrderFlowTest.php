<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\Order;
use App\Models\SellerWithdrawal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_order_stores_admin_fee_breakdown(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $seller = User::factory()->create(['role' => 'seller', 'store_name' => 'Warung Hemat']);
        $food = Food::create([
            'seller_id' => $seller->id,
            'name' => 'Nasi Box',
            'description' => 'Siap pickup',
            'original_price' => 20000,
            'discount_price' => 10000,
            'stock' => 5,
            'pickup_time_start' => '18:00',
            'pickup_time_end' => '20:00',
            'status' => 'available',
        ]);

        $response = $this->actingAs($customer)->post(route('order.store', $food->id), [
            'quantity' => 2,
            'accepted_order_terms' => '1',
        ]);

        $response->assertRedirect(route('order.history'));

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id,
            'food_id' => $food->id,
            'quantity' => 2,
            'subtotal_price' => 20000,
            'admin_fee' => 1000,
            'total_price' => 21000,
        ]);
    }

    public function test_customer_can_submit_review_after_completed_order(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $seller = User::factory()->create(['role' => 'seller', 'store_name' => 'Warung Hemat']);
        $food = Food::create([
            'seller_id' => $seller->id,
            'name' => 'Roti',
            'description' => 'Masih layak',
            'original_price' => 15000,
            'discount_price' => 7500,
            'stock' => 3,
            'pickup_time_start' => '08:00',
            'pickup_time_end' => '10:00',
            'status' => 'available',
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'food_id' => $food->id,
            'quantity' => 1,
            'subtotal_price' => 7500,
            'admin_fee' => 1000,
            'total_price' => 8500,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($customer)->post(route('reviews.store', $order), [
            'target_type' => 'application',
            'rating' => 5,
            'comment' => 'Mudah dipakai',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'target_type' => 'application',
            'rating' => 5,
        ]);
    }

    public function test_completed_order_adds_seller_balance_and_withdraw_records_commission(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $seller = User::factory()->create(['role' => 'seller', 'store_name' => 'Warung Hemat']);
        $food = Food::create([
            'seller_id' => $seller->id,
            'name' => 'Nasi Bakar',
            'description' => 'Fresh',
            'original_price' => 18000,
            'discount_price' => 9000,
            'stock' => 4,
            'pickup_time_start' => '18:00',
            'pickup_time_end' => '20:00',
            'status' => 'available',
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'food_id' => $food->id,
            'quantity' => 2,
            'subtotal_price' => 18000,
            'admin_fee' => 1000,
            'total_price' => 19000,
            'status' => 'pending',
        ]);

        $completeResponse = $this->actingAs($seller)->patch(route('order.complete', $order->id));
        $completeResponse->assertRedirect();

        $seller->refresh();
        $this->assertSame('18000.00', $seller->seller_balance);
        $this->assertSame('18000.00', $seller->seller_total_earned);

        $withdrawResponse = $this->actingAs($seller)->post(route('seller.withdraw'), [
            'amount' => 10000,
        ]);
        $withdrawResponse->assertRedirect();

        $seller->refresh();
        $this->assertSame('8000.00', $seller->seller_balance);
        $this->assertSame('9000.00', $seller->seller_total_withdrawn);
        $this->assertSame('1000.00', $seller->seller_total_commission_paid);

        $this->assertDatabaseHas('seller_withdrawals', [
            'seller_id' => $seller->id,
            'gross_amount' => 10000,
            'commission_amount' => 1000,
            'net_amount' => 9000,
        ]);

        $this->assertSame(1, SellerWithdrawal::count());
    }

    public function test_supplier_rating_is_rejected(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $seller = User::factory()->create(['role' => 'seller']);
        $food = Food::create([
            'seller_id' => $seller->id,
            'name' => 'Roti Sobek',
            'description' => 'Layak jual',
            'original_price' => 10000,
            'discount_price' => 5000,
            'stock' => 2,
            'pickup_time_start' => '08:00',
            'pickup_time_end' => '10:00',
            'status' => 'available',
        ]);

        $order = Order::create([
            'customer_id' => $customer->id,
            'food_id' => $food->id,
            'quantity' => 1,
            'subtotal_price' => 5000,
            'admin_fee' => 1000,
            'total_price' => 6000,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($customer)->post(route('reviews.store', $order), [
            'target_type' => 'supplier',
            'rating' => 5,
        ]);

        $response->assertSessionHasErrors('target_type');
    }
}
