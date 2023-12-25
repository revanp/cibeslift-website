<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_id', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_history_id');
            $table->text('description');
            $table->string('language_code', 5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_id');
        Schema::dropIfExists('history');
    }
};
