<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('product_specification');
        Schema::create('product_specification', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_id');
            $table->text('size')->nullable();
            $table->string('installation')->nullable();
            $table->string('rated_load')->nullable();
            $table->string('power_supply')->nullable();
            $table->string('speed')->nullable();
            $table->string('min_headroom')->nullable();
            $table->string('lift_pit')->nullable();
            $table->string('drive_system')->nullable();
            $table->string('max_travel')->nullable();
            $table->string('max_number_of_stops')->nullable();
            $table->string('lift_controls')->nullable();
            $table->string('motor_power')->nullable();
            $table->string('machine_room')->nullable();
            $table->string('door_configuration')->nullable();
            $table->string('directive_and_standards')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specification');
    }
};
