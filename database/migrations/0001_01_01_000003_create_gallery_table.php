<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Artists
        Schema::create('artists', function (Blueprint $table) {
            $table->id('artist_id');
            $table->string('name');
            $table->integer('year')->nullable();
            $table->text('description')->nullable();
            $table->string('img_path')->nullable();
            $table->timestamps();
        });

        // 2. Artworks (depends on artists)
        Schema::create('artworks', function (Blueprint $table) {
            $table->id('artwork_id');
            $table->string('title');
            // $table->integer('artist_id');
            $table->integer('year')->nullable();
            $table->string('genre')->nullable();
            $table->integer('price')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreignID('artist_id')->references('artist_id')->on('artists')->cascadeOnDelete();
        });

        // 3. Orders (depends on users)
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('price')->default(0);
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        // 4. Order items (depends on orders + artworks)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_item_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('artwork_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('orders')->cascadeOnDelete();
            $table->foreign('artwork_id')->references('artwork_id')->on('artworks')->cascadeOnDelete();
        });

        // 5. Cart items (depends on users + artworks)
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('cart_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('artwork_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('artwork_id')->references('artwork_id')->on('artworks')->cascadeOnDelete();
        });

        // 6. Save items (depends on users + artworks)
        Schema::create('save_items', function (Blueprint $table) {
            $table->id('save_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('artwork_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('artwork_id')->references('artwork_id')->on('artworks')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('save_items');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('artworks');
        Schema::dropIfExists('artists');
    }
};
