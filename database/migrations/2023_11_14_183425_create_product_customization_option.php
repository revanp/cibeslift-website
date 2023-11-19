<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_customization_option_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_customization_id');
            $table->bigInteger('parent_id')->nullable();
            $table->boolean('have_a_child');
            $table->integer('level');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_customization_option', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_customization_option_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_customization_option_id');
        Schema::dropIfExists('product_customization_option');
    }
};
