<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_customization_option_variation_id', function (Blueprint $table) {
            $table->renameColumn('product_customization_option_id', 'id_product_customization_option_id');
        });
    }

    public function down(): void
    {
        Schema::table('product_customization_option_variation_id', function (Blueprint $table) {
            $table->renameColumn('id_product_customization_option_id', 'product_customization_option_id');
        });
    }
};
