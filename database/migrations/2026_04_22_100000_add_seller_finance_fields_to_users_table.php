<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('seller_balance', 12, 2)->default(0)->after('accepted_pnc_at');
            $table->decimal('seller_total_earned', 12, 2)->default(0)->after('seller_balance');
            $table->decimal('seller_total_withdrawn', 12, 2)->default(0)->after('seller_total_earned');
            $table->decimal('seller_total_commission_paid', 12, 2)->default(0)->after('seller_total_withdrawn');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'seller_balance',
                'seller_total_earned',
                'seller_total_withdrawn',
                'seller_total_commission_paid',
            ]);
        });
    }
};
