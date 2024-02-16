<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_us_aftersales_title', function (Blueprint $table) {
            $table->string('cta')->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('about_us_aftersales_title', function (Blueprint $table) {
            $table->dropColumn('cta');
        });
    }
};
