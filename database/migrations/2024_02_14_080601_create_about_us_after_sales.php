<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_us_aftersales_id', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('sort');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('about_us_aftersales', function (Blueprint $table) {
            $table->id();
            $table->integer('id_about_us_aftersales_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us_aftersales_id');
        Schema::dropIfExists('about_us_aftersales');
    }
};
