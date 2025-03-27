<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {

        Schema::create('properties', function (Blueprint $table) {
            $table->id('propertyId');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('postalCode');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
            $table->unsignedBigInteger('ownerId')->default(null)->index();
            $table->unsignedBigInteger('agentId')->index();
            $table->boolean('isSold')->default(false)->index();
            $table->enum('propertyType', ['House', 'Condo', 'Cottage', 'Multiplex'])->index();
            $table->integer('floors');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('squareFootage', 10, 2);
            $table->integer('yearBuilt');
            $table->boolean('isGarage')->default(false);
            $table->timestamp('createdAt')->useCurrent();

            $table->foreign('ownerId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('agentId')->references('userId')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('properties');
    }
};
