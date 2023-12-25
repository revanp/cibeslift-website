<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('history_id', function(Blueprint $table){
            $table->integer('sort')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('history_id', function(Blueprint $table){
            $table->dropColumn('sort');
        });
    }
};
