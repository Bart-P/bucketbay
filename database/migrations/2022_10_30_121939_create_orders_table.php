<?php

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    protected array $casts = ['status' => OrderStatusEnum::class,];

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->integer('delivery_address_id');
            $table->date('sent_at')->nullable();
            $table->integer('print_price_in_cent')->startingValue(0);
            $table->integer('shipment_price_in_cent')->startingValue(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};