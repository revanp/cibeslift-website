<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manufacture_id', function (Blueprint $table) {
            $table->id();
            $table->string('location')->nullable();
            $table->boolean('is_coming_soon')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('manufacture', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_manufacture_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('manufacture_id_has_product_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_manufacture_id');
            $table->bigInteger('id_product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manufacture_id');
        Schema::dropIfExists('manufacture');
        Schema::dropIfExists('manufacture_id_has_product_id');
    }
};
