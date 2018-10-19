<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTeamsCompetitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_competitions', function (Blueprint $table) {
			// Primary Key
            $table->increments('id');

			// Columns
			$table->bigInteger('team_id')->unsigned();
			$table->integer('competition_id')->unsigned();
			$table->integer('group_id')->unsigned()->nullable();
			$table->integer('order');
            $table->timestamps();

			// Indexes
			$table->unique(['team_id', 'competition_id']);

			// Foreign Key Constraints
			$table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
			$table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
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
        Schema::dropIfExists('teams_competitions');
    }
}
