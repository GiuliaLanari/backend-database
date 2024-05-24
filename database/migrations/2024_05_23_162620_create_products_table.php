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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('picture')->nullable();
            $table->string('summary')->nullable();// cosa si intende?? 
            $table->text('description');
            $table->mediumInteger('price')->unsigned();
            $table->timestamps();

            $table->foreignId('category_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Schema::table('products', function (Blueprint $table) {
        //     $table->dropColumn(['category_id']);
        // });

        
        Schema::dropIfExists('products');
    }
};
