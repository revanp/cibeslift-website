<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('product_image_id', 'product_usp_id');
        Schema::rename('product_image', 'product_usp');
    }

    public function down(): void
    {
        Schema::rename('product_usp_id', 'product_image_id');
        Schema::rename('product_usp', 'product_image');
    }
};
