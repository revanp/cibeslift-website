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
        Schema::dropIfExists('product');
        Schema::dropIfExists('product_category');
        Schema::dropIfExists('product_category_id');
        Schema::dropIfExists('product_group');
        Schema::dropIfExists('product_group_id');
        Schema::dropIfExists('product_id');
        Schema::dropIfExists('product_product_has_property');
        Schema::dropIfExists('product_property');
        Schema::dropIfExists('product_property_id');
        Schema::dropIfExists('product_property_value');
        Schema::dropIfExists('product_property_value_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('drop_all_products');
    }
};
