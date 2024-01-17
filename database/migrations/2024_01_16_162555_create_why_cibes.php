<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_cibes_title', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('why_cibes_usp_id', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->integer('sort');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('why_cibes_usp', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_why_cibes_usp_id');
            $table->string('title');
            $table->string('subtitle');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_cibes_title');
        Schema::dropIfExists('why_cibes_usp_id');
        Schema::dropIfExists('why_cibes_usp');
    }
};
