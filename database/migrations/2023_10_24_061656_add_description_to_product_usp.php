<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('product_usp', function (Blueprint $table) {
            $table->renameColumn('id_product_image_id', 'id_product_usp_id');
            $table->text('description')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('product_usp', function (Blueprint $table) {
            $table->renameColumn('id_product_usp_id', 'id_product_image_id');
            $table->dropColumn('description');
        });
    }
};
