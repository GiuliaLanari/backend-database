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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment', 400);
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('product_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Schema::table('reviews', function (Blueprint $table) {
        //     $table->dropColumn(['user_id']);
        //     $table->dropColumn(['product_id']);
        // });

        
        Schema::dropIfExists('reviews');
    }
};
