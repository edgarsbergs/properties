<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 128)->unique();
            $table->unsignedSmallInteger('property_type_id');
            $table->string('country');
            $table->string('county');
            $table->string('town');
            $table->text('description');
            $table->string('address');
            $table->string('image_full');
            $table->string('image_thumbnail');
            $table->string('latitude',50);
            $table->string('longitude', 50);
            $table->unsignedSmallInteger('num_bedrooms'); // small integer because of big houses, otherwise tinyInt
            $table->unsignedSmallInteger('num_bathrooms'); // small integer because of big houses
            $table->decimal('price', '14', '2');
            $table->string('type');
            $table->timestamps();

            $table->foreign('property_type_id')->on('property_types')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
