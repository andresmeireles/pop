<?php

declare(strict_types=1);

use Hyperf\Database\Migrations\Migration;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Schema\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('height')->nullable();
            $table->float('original_value');
        });

        Schema::create('customers', static function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->string('trade_name')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('email')->nullable();
        });

        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
        });

        Schema::create('sellers', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained();
        });

        Schema::create('orders', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('seller_id')->constrained();
            $table->timestamps();
        });

        Schema::create('order_products', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->float('amount');
            $table->integer('quantity');
        });

        Schema::create('additionals', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('value');
            $table->boolean('addition');
            $table->foreignId('order_id')->constrained();
        });

        Schema::create('regions', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('seller_id')->constrained();
        });

        Schema::create('product_categories', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('freights', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained();
            $table->float('value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freights');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('regions');
        Schema::dropIfExists('additionals');
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('sellers');
        Schema::dropIfExists('users');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('products');
    }
};
