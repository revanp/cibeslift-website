<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_banner', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_header_banner_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cta')->nullable();
            $table->string('link')->nullable();
            $table->string('language_code',5);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_banner');
    }
};
