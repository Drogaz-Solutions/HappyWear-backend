<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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

            $table->unsignedBigInteger("seller_id");
            $table->foreign("seller_id")->references("id")->on("users");

            $table->string("name");
            $table->string("description");
            $table->string("image");
            $table->string("price");

            $table->string("kind");
            $table->string("model");
            $table->string("main_color");
            $table->string("other_color");
            $table->string("size");
            $table->string("material");
            $table->string("condition");
            $table->string("brand");
            $table->string('sex');
            // $table->string("bought_at");

            $table->boolean("available")->default(true);

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
};
