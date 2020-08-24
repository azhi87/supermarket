<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('barcode', 100);
            $table->double('sale_price')->default(0.0);
            $table->integer('sale_price_id')->default(1);
            $table->integer('items_per_box');
            $table->double('purchase_price')->default(0.0);
            $table->text('description')->nullable();
            $table->integer('category_id');
            $table->integer('supplier_id')->default(1);
            $table->integer('manufacturer_id');
            $table->double('sale_price_discount')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->integer('maxzan')->nullable()->default(0);
            $table->string('name', 300);
            $table->string('name_en', 300)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
