<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('product_category', 'x_product_category');
        Schema::rename('product_category_customization', 'x_product_category_customization');
        Schema::rename('product_category_customization_id', 'x_product_category_customization_id');
        Schema::rename('product_category_feature', 'x_product_category_feature');
        Schema::rename('product_category_feature_id', 'x_product_category_feature_id');
        Schema::rename('product_category_id', 'x_product_category_id');
        Schema::rename('product_category_id_has_product_technology_id', 'x_product_category_id_has_product_technology_id');
        Schema::rename('product_category_usp', 'x_product_category_usp');
        Schema::rename('product_category_usp_id', 'x_product_category_usp_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
