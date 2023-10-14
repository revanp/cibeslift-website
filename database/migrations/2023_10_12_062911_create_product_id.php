<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_id', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_category_id');
            $table->integer('id_product_property_id');
            $table->string('view_360_image')->nullable();
            $table->string('view_360_image_2')->nullable();
            $table->string('discover_video')->nullable();
            $table->string('compare_link')->nullable();
            $table->string('download_catalogue_link')->nullable();
            $table->string('download_drawing_link_thumbnail')->nullable();
            $table->boolean('is_top')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_id');
    }
};
