<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news_id', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_news_category_id');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_top')->default(false);
            $table->boolean('is_home')->default(false);
            $table->dateTime('publish_date');
            $table->integer('sort');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_id');
    }
};
