<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_feature_id', function (Blueprint $table) {
            $table->dropColumn('sort');
            $table->dropColumn('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('product_feature_id', function (Blueprint $table) {
            $table->integer('sort')->after('id_product_id');
            $table->integer('is_active')->after('sort');
        });
    }
};
