<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_us_aftersales_title', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us_aftersales_title');
    }
};
