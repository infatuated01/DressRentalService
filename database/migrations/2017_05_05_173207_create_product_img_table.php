<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img_url');
            $table->integer('product_id')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('product_images');
        Schema::enableForeignKeyConstraints();
    }
}
