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
        Schema::create('categories', function(Blueprint $table){
            $table->increments('id');
            $table->string('category');
            $table->string('description');
            $table->boolean('isArchived');
            $table->timestamps();
        });


        Schema::create('suppliers', function(Blueprint $table){
            $table->increments('id');
            $table->string('supplier_name');
            $table->string('supplier_number');
            $table->boolean('supplier_email');
            $table->timestamps();
        });


        Schema::create('product_infos', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('image');
            $table->string('serial_number');
            $table->string('manufacturer');
            $table->string('product_name');
            $table->string('description');
            $table->string('price');
            $table->string('selling_price');
            $table->string('size');
            $table->boolean('isArchived');
            $table->timestamps();

            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');
        });


        Schema::create('inventories', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('supplier_id');
            $table->string('category');
            $table->string('supplier');
            $table->string('supplier_email');
            $table->string('supplier_number');
            $table->bigInteger('stocks');
            $table->bigInteger('safety_stocks');
            $table->string('stock_by');
            $table->string('updated_by');
            $table->date('production_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->string('status');
            $table->boolean('noExpiration');
            $table->timestamps();

            $table->foreign('product_id')
            ->references('id')
            ->on('product_infos')
            ->onDelete('cascade');


            $table->foreign('supplier_id')
            ->references('id')
            ->on('suppliers')
            ->onDelete('cascade');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
