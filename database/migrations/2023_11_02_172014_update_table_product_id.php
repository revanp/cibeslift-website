<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_id', function($table){
            $table->integer('product_summary_type')->comment('0 => list product, 1 => big banner with text on the left side, 2 => big banner with overlay and center text, 3 => big banner without overlay and black text')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_id', function($table){
            $table->integer('product_summary_type')->comment('0 => list product, 1 => big banner with text on the left side, 2 => big banner with overlay and center text, 3 => big banner without overlay and black text')->change();
        });
    }
};
