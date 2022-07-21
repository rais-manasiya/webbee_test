<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all creates for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the creates that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('Movie', function(Blueprint $create)
        {
            $create->integer('movieID')->unsigned()->nullable();
            $create->text('description');
            $create->dateTime('duration', $precision = 0);
            $create->string('language');
            $create->dateTime('realeseDate');
            $create->string('country');
            $create->string('genre');
            $create->timestamps();
        });

        
        Schema::create('City', function($table) {
            
            $create->increments('cityID');
            $create->string('name',64);
            $create->string('size',64);
            $create->string('pincode',12);
        });

        Schema::create('Cinema', function(Blueprint $create)
        {
            $create->integer('cinemaID')->unsigned()->nullable();
            $create->integer('totalCinemaHall');
            $create->foreign('city_ID')
                    ->references('cityID')
                    ->on('City')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('CinemaHall', function(Blueprint $create)
        {
            $create->integer('cinemaHallID')->unsigned()->nullable();
            $create->string('name');
            $create->integer('totalSeats');
            $create->foreign('cinemaID')
                    ->references('cinemaID')
                    ->on('Cinema')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });


        Schema::create('Show', function(Blueprint $create)
        {
            $create->integer('showID')->unsigned()->nullable();
            $create->dateTime('startTime');
            $create->dateTime('endTime');
            $create->foreign('cinemaHallId')
                    ->references('cinemaHallId')
                    ->on('CinemaHall')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $create->foreign('MovieId')
                    ->references('movieID')
                    ->on('Movie')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        
        Schema::create('CinemaSeat', function(Blueprint $create)
        {
            $create->integer('cinemaSeatID')->unsigned()->nullable();
            $create->integer('seatNumber');
            $create->enum('type', ['Orchestra', 'Mezzanine','Balcony']);
            $create->foreign('cinemaHallID')
                    ->references('cinemaHallID')
                    ->on('CinemaHall')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('Booking', function(Blueprint $create)
        {
            $create->integer('bookingID')->unsigned()->nullable();
            $create->integer('noOfSeats');
            $create->dateTime('Timestamp');
            $create->enum('status', ['booked', 'cancelled']);
            $create->foreign('userID')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $create->foreign('showID')
                    ->references('showID')
                    ->on('Show')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });



        Schema::create('ShowSeat', function(Blueprint $create)
        {
            $create->integer('showSeatID')->unsigned()->nullable();
            $create->integer('price');
            $create->enum('status', ['Available', 'Booked']);
            $create->foreign('cinemaSeatID')
                    ->references('cinemaSeatID')
                    ->on('CinemaSeat')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $create->foreign('showID')
                    ->references('showID')
                    ->on('Show')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $create->foreign('bookingID')
                    ->references('bookingID')
                    ->on('Booking')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Movie');
        Schema::dropIfExists('Show');
        Schema::dropIfExists('Boking');
        Schema::dropIfExists('Cinema');
        Schema::dropIfExists('CinemaHall');
        Schema::dropIfExists('City');
        Schema::dropIfExists('CinemaSeat');
        Schema::dropIfExists('ShowSeat');


    }
}
