<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::drop('x_product_category');
        Schema::drop('x_product_category_customization');
        Schema::drop('x_product_category_customization_id');
        Schema::drop('x_product_category_feature');
        Schema::drop('x_product_category_feature_id');
        Schema::drop('x_product_category_id');
        Schema::drop('x_product_category_id_has_product_technology_id');
        Schema::drop('x_product_category_usp');
        Schema::drop('x_product_category_usp_id');
    }

    public function down(): void
    {
        //
    }
};
