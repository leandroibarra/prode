<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMatchesPredictions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches_predictions', function (Blueprint $table) {
			// Primary Key
            $table->bigIncrements('id');

            // Columns
			$table->bigInteger('match_schedule_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->enum('result', ['home', 'draw', 'away'])->nullable();

            $table->timestamps();

			// Foreign Key Constraints
			$table->foreign('match_schedule_id')->references('id')->on('matches_schedules');
			$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches_predictions');
    }
}
