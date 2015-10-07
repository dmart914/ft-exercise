<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('mls_number')->unique();
            
            $table->string('street_1', 250);
            $table->string('street_2', 250);
            $table->string('city', 250);
            $table->string('state', 250);
            $table->integer('zip');
            $table->string('neighborhood', 250);

            $table->integer('sale_price');
            $table->date('date_listed');
            $table->integer('bedrooms');
            $table->mediumText('photos');
            $table->integer('square_feet');
            $table->mediumText('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listings');
    }
}
