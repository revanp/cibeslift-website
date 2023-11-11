<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('product_faq_id');
        Schema::dropIfExists('product_faq');

        Schema::create('product_id_has_faq_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_id');
            $table->bigInteger('id_faq_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_id_has_faq_id');
    }
};
