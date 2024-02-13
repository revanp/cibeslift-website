<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nation_id', function (Blueprint $table) {
            $table->string('link')->after('id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('nation_id', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};
