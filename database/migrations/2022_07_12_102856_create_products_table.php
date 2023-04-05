<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uid')->nullable();
            $table->string('avatar')->nullable();
            $table->string('images')->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('stock')->unsigned();
            $table->bigInteger('brand');
            $table->bigInteger('category');
            $table->float('price');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->boolean('show')->default(true);
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
        Schema::dropIfExists('products');
    }
}
