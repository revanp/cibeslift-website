<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product', function(Blueprint $table){
            $table->text('video_description')->nullable()->after('description');
        });

        Schema::table('product_id', function(Blueprint $table){
            $table->string('video_url')->nullable()->after('level');
        });
    }

    public function down(): void
    {
        Schema::table('product', function(Blueprint $table){
            $table->dropColumn('video_description');
        });

        Schema::table('product_id', function(Blueprint $table){
            $table->dropColumn('video_url');
        });
    }
};
