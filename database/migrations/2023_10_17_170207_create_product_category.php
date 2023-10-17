<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_category_id', function (Blueprint $table) {
            $table->id();
            $table->integer('product_summary_type')->comment('0 => list product, 1 => big banner with text on the left side, 2 => big banner with overlay and center text, 3 => big banner without overlay and black text');
            $table->integer('sort');
            $table->boolean('is_active')->default(true);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_category_id');
            $table->string('name');
            $table->string('slug');
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('page_title');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keyword')->nullable();
            $table->string('seo_canonical_url')->nullable();
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_category_id');
        Schema::dropIfExists('product_category');
    }
};
