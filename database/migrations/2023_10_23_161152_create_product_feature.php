<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_feature_id', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_id');
            $table->integer('sort');
            $table->integer('is_active');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_feature', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_feature_id');
            $table->string('name');
            $table->text('description');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_feature_id');
        Schema::dropIfExists('product_feature');
    }
};
