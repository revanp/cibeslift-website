<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_customization_option_id', function (Blueprint $table) {
            $table->boolean('have_a_child')->after('parent_id');

        });
    }

    public function down(): void
    {
        Schema::table('product_customization_option_id', function (Blueprint $table) {
            $table->dropColumn('have_a_child');
        });
    }
};
