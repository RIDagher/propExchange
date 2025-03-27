<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {

        Schema::create('property_images', function (Blueprint $table) {
            $table->id('imageId');
            $table->unsignedBigInteger('propertyId');
            $table->string('imagePath');
            $table->boolean('isMain')->default(false)->index();

            $table->foreign('propertyId')->references('propertyId')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('property_images');
    }
};
