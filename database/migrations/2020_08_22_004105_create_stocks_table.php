<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id');
            $table->double('quantity');
            $table->date('exp')->nullable();
            $table->double('bonus')->default(0);
            $table->enum('type', ['broken', 'sale', 'purchase', 'return', 'returned_sale', 'returned_purchase']);
            $table->integer('source_id');
            $table->double('ppi');
            $table->double('rate');
            $table->text('description')->nullable();
            $table->string('batch_no', 100)->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
