<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_faq_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });

        Schema::create('product_faq', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_faq_id');
            $table->string('title');
            $table->text('description');
            $table->string('language_code',5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_faq_id');
        Schema::dropIfExists('product_faq');
    }
};
