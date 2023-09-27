<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('mediable');
            $table->uuid('uuid')->nullable();
            $table->string('content_type')->nullable();
            $table->string('name');
            $table->text('path');
            $table->string('file_name');
            $table->string('type');
            $table->string('mime_type')->nullable();
            $table->string('extension');
            $table->string('disk');
            $table->double('size');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
