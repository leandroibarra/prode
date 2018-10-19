<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMatchesSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches_schedules', function (Blueprint $table) {
        	// Primary Key
            $table->bigIncrements('id');

			// Columns
            $table->bigInteger('home_team_id')->unsigned()->nullable();
            $table->bigInteger('away_team_id')->unsigned()->nullable();
            $table->integer('instance_id')->unsigned();
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('match_day')->unsigned()->nullable();
            $table->integer('home_goals')->unsigned()->nullable();
            $table->integer('away_goals')->unsigned()->nullable();
			$table->integer('home_goals_penalties')->unsigned()->nullable();
			$table->integer('away_goals_penalties')->unsigned()->nullable();
			$table->enum('final_result', ['home', 'draw', 'away'])->nullable();
			$table->datetime('utc_datetime')->nullable();
			$table->timestamps();

			// Foreign Key Constraints
			$table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
			$table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
			$table->foreign('instance_id')->references('id')->on('instances')->onDelete('cascade');
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches_schedules');
    }
}
