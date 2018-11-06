<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCompetitions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('competitions', function (Blueprint $table) {
			// Columns
			$table->string('name_es', 255)->after('name');
			$table->renameColumn('name', 'name_en');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('competitions', function (Blueprint $table) {
			// Columns
			$table->dropColumn(['name_es']);
			$table->renameColumn('name_en', 'name');
		});
	}
}
