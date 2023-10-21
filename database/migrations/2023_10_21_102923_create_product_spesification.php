<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_specification', function (Blueprint $table) {
            $table->id();
            $table->integer('id_product_id');
            $table->text('size')->nullable();
            $table->string('installation')->nullable();
            $table->string('power_supply')->nullable();
            $table->string('min_headroom')->nullable();
            $table->string('drive_system')->nullable();
            $table->string('max_number_of_stops')->nullable();
            $table->string('door_configuration')->nullable();
            $table->string('rated_load')->nullable();
            $table->string('speed_max')->nullable();
            $table->string('lift_pit')->nullable();
            $table->string('max_travel')->nullable();
            $table->string('motor_power')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specification');
    }
};
