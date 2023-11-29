`<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_installation_size_id', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_size', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_installation_size_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_floor_size_id', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_floor_size', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_installation_floor_size_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_area_id', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_area', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_installation_area_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_location_id', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_location', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_installation_location_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_color_id', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation_color', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_installation_color_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_installation_size_id');
        Schema::dropIfExists('product_installation_size');
        Schema::dropIfExists('product_installation_floor_size_id');
        Schema::dropIfExists('product_installation_floor_size');
        Schema::dropIfExists('product_installation_area_id');
        Schema::dropIfExists('product_installation_area');
        Schema::dropIfExists('product_installation_location_id');
        Schema::dropIfExists('product_installation_location');
        Schema::dropIfExists('product_installation_color_id');
        Schema::dropIfExists('product_installation_color');
    }
};
