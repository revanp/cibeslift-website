<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_customization_option_variation_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_customization_option_id');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_customization_option_variation', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_customization_option_variation_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_customization_option_variation_id');
        Schema::dropIfExists('product_customization_option_variation');
    }
};
