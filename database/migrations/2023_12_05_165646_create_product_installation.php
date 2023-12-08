<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_installation_id', function (Blueprint $table) {
            $table->string('location')->nullable()->after('id_product_installation_color_id');
            $table->string('number_of_stops')->nullable()->after('location');
            $table->boolean('is_active')->default(true)->after('number_of_stops');
        });
    }

    public function down(): void
    {
        Schema::table('product_installation_id', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('number_of_stops');
            $table->dropColumn('is_active');
        });
    }
};
