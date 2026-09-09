<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal_price', 10, 2)->default(0)->after('quantity');
            $table->decimal('admin_fee', 10, 2)->default(0)->after('subtotal_price');
        });

        DB::table('orders')->update([
            'subtotal_price' => DB::raw('total_price'),
            'admin_fee' => 0,
        ]);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal_price', 'admin_fee']);
        });
    }
};
