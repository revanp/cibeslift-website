<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonial_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_id');
            $table->boolean('is_active')->default(true);
            $table->integer('sort');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('testimonial', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_testimonial_id');
            $table->string('customer');
            $table->text('testimony');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonial_id');
        Schema::dropIfExists('testimonial');
    }
};
