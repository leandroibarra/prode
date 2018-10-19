<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableMatchesSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches_schedules', function (Blueprint $table) {
        	// Columns
            $table->integer('competition_id')->unsigned()->after('id');
            $table->tinyInteger('points')->unsigned()->after('away_goals_penalties');

			// Foreign Key Constraints
			$table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matches_schedules', function (Blueprint $table) {
			// Foreign Key Constraints
        	$table->dropForeign('matches_schedules_competition_id_foreign');

        	// Columns
			$table->dropColumn(['competition_id', 'points']);
        });
    }
}
