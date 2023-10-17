<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_technology_id', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_technology', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_technology_id');
            $table->string('name');
            $table->text('description');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_category_id_has_product_technology_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_category_id');
            $table->bigInteger('id_product_technology_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_technology_id');
        Schema::dropIfExists('product_technology');
        Schema::dropIfExists('product_category_id_has_product_technology_id');
    }
};
