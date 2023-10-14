<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_product_id');
            $table->string('name');
            $table->string('slug');
            $table->string('title');
            $table->text('description');
            $table->string('characteristic_title')->nullable();
            $table->text('characteristic_description')->nullable();
            $table->string('safety_title')->nullable();
            $table->string('safety_description')->nullable();
            $table->string('safety_1')->nullable();
            $table->text('safety_1_content')->nullable();
            $table->string('safety_2')->nullable();
            $table->text('safety_2_content')->nullable();
            $table->string('safety_3')->nullable();
            $table->text('safety_3_content')->nullable();
            $table->string('view_360_title')->nullable();
            $table->string('specs_title')->nullable();
            $table->text('specs_size')->nullable();
            $table->text('specs_general')->nullable();
            $table->string('discover_title')->nullable();
            $table->text('discover_description')->nullable();
            $table->string('color_title')->nullable();
            $table->text('color_lift_title')->nullable();
            $table->text('color_lift_floor_title')->nullable();
            $table->text('color_lift_center_title')->nullable();
            $table->text('color_lift_door_title')->nullable();
            $table->text('color_lift_other_title')->nullable();
            $table->text('color_lift_side_open_title')->nullable();
            $table->string('support_title')->nullable();
            $table->string('post_1_title')->nullable();
            $table->text('post_1_content')->nullable();
            $table->string('post_2_title')->nullable();
            $table->text('post_2_content')->nullable();
            $table->string('post_2_button')->nullable();
            $table->string('post_2_button_link')->nullable();
            $table->string('service_title')->nullable();
            $table->text('service_description')->nullable();
            $table->string('service_1_title')->nullable();
            $table->text('service_1_content')->nullable();
            $table->string('service_2_title')->nullable();
            $table->text('service_2_content')->nullable();
            $table->string('service_3_title')->nullable();
            $table->text('service_3_content')->nullable();
            $table->text('compare_description')->nullable();
            $table->text('compare_design')->nullable();
            $table->text('compare_special_edition')->nullable();
            $table->string('compare_setup_location')->nullable();
            $table->string('compare_weight_load')->nullable();
            $table->string('compare_journey_height')->nullable();
            $table->string('compare_pit_depth')->nullable();
            $table->string('compare_max_lift_stop')->nullable();
            $table->string('compare_speed')->nullable();
            $table->string('compare_top_well_height')->nullable();
            $table->text('compare_floor_dimensions')->nullable();
            $table->text('compare_clearence_dimensions')->nullable();
            $table->string('compare_door_type')->nullable();
            $table->string('compare_machine_room_type')->nullable();
            $table->string('compare_transmission_system')->nullable();
            $table->string('compare_control_system')->nullable();
            $table->string('compare_engine_power')->nullable();
            $table->text('supply')->nullable();
            $table->string('standard')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keyword')->nullable();
            $table->string('seo_canonical_url')->nullable();
            $table->string('language_code',5);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
