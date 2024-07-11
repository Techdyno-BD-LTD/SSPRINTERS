<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_challan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_challan_id')->constrained();
            $table->foreignId('invoice_item_id')->constrained();
            $table->integer('quantity');
            $table->string('unit');
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_challan_items');
    }
};
