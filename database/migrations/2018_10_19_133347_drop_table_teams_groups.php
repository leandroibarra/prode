<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableTeamsGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::dropIfExists('teams_groups');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::create('teams_groups', function (Blueprint $table) {
			// Primary Key
			$table->increments('id');

			// Columns
			$table->bigInteger('team_id')->unsigned();
			$table->integer('group_id')->unsigned();
			$table->integer('order');
			$table->timestamps();

			// Indexes
			$table->unique(['team_id', 'group_id']);

			// Foreign Key Constraints
			$table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
		});
    }
}
