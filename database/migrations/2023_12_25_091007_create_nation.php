<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nation_id', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('sort');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('nation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_nation_id');
            $table->string('name');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nation_id');
        Schema::dropIfExists('nation');
    }
};
