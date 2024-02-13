<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_us_banner_id', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('about_us_banner', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_about_us_banner_id');
            $table->string('title');
            $table->string('description');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us_banner_id');
        Schema::dropIfExists('about_us_banner');
    }
};
