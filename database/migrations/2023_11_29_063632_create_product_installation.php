<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_installation_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_id');
            $table->bigInteger('id_product_installation_size_id');
            $table->bigInteger('id_product_installation_floor_size_id');
            $table->bigInteger('id_product_installation_area_id');
            $table->bigInteger('id_product_installation_location_id');
            $table->bigInteger('id_product_installation_color_id');
            $table->date('installation_date')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_installation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_installation_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_installation_id');
        Schema::dropIfExists('product_installation');
    }
};
