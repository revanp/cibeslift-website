<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_menu_section_id', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->boolean('is_active')->default(true);
            $table->integer('sort');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('home_menu_section', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_home_menu_section_id');
            $table->string('title');
            $table->text('description');
            $table->string('cta')->nullable()->nullable();
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_menu_section_id');
        Schema::dropIfExists('home_menu_section');
    }
};
