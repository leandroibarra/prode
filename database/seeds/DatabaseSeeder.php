<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	private $aTeams = [
		[1, 'ARG', 'Argentina'],
		[2, 'AUS', 'Australia'],
		[3, 'BEL', 'Belgium'],
		[4, 'BRA', 'Brazil'],
		[5, 'CHE', 'Switzerland'],
		[6, 'COL', 'Colombia'],
		[7, 'CRI', 'Costa Rica'],
		[8, 'DEU', 'Germany'],
		[9, 'DNK', 'Denmark'],
		[10, 'EGY', 'Egypt'],
		[11, 'ENG', 'England'],
		[12, 'ESP', 'Spain'],
		[13, 'FRA', 'France'],
		[14, 'HRV', 'Croatia'],
		[15, 'IRN', 'Iran'],
		[16, 'ISL', 'Iceland'],
		[17, 'JPN', 'Japan'],
		[18, 'KOR', 'South Korea'],
		[19, 'MAR', 'Morocco'],
		[20, 'MEX', 'Mexico'],
		[21, 'NGA', 'Nigeria'],
		[22, 'PAN', 'Panama'],
		[23, 'PER', 'Peru'],
		[24, 'POL', 'Poland'],
		[25, 'PRT', 'Portugal'],
		[26, 'RUS', 'Russia'],
		[27, 'SAU', 'Saudi Arabia'],
		[28, 'SEN', 'Senegal'],
		[29, 'SRB', 'Serbia'],
		[30, 'SWE', 'Sweden'],
		[31, 'TUN', 'Tunisia'],
		[32, 'URY', 'Uruguay']
	];

	private $aGroups = [
		[1,	'A'],
		[2,	'B'],
		[3,	'C'],
		[4,	'D'],
		[5,	'E'],
		[6,	'F'],
		[7,	'G'],
		[8,	'H']
	];

	private $aInstances = [
		[1,	'Group Phase'],
		[2,	'Round of 16'],
		[3,	'Quarter-finals'],
		[4,	'Semi-finals'],
		[5,	'Play-off for third place'],
		[6,	'Final']
	];

	private $aCompetitions = [
		[1, 'FIFA World Cup 2018']
	];

	private $aTeamsCompetitions = [
		[10, 1, 1, 1],
		[26, 1, 1, 2],
		[27, 1, 1, 3],
		[32, 1, 1, 4],
		[12, 1, 2, 1],
		[15, 1, 2, 2],
		[19, 1, 2, 3],
		[25, 1, 2, 4],
		[2, 1, 3, 1],
		[9, 1, 3, 2],
		[13, 1, 3, 3],
		[23, 1, 3, 4],
		[1, 1, 4, 1],
		[14, 1, 4, 2],
		[16, 1, 4, 3],
		[21, 1, 4, 4],
		[4, 1, 5, 1],
		[5, 1, 5, 2],
		[7, 1, 5, 3],
		[29, 1, 5, 4],
		[8, 1, 6, 1],
		[18, 1, 6, 2],
		[20, 1, 6, 3],
		[30, 1, 6, 4],
		[3, 1, 7, 1],
		[11, 1, 7, 2],
		[22, 1, 7, 3],
		[31, 1, 7, 4],
		[6, 1, 8, 1],
		[17, 1, 8, 2],
		[24, 1, 8, 3],
		[28, 1, 8, 4]
	];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	foreach ($this->aTeams as $aTeam)
    		DB::table('teams')->insert([
    			'id' => $aTeam[0],
				'code' => $aTeam[1],
				'name' => $aTeam[2],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);

		foreach ($this->aGroups as $aGroup)
			DB::table('groups')->insert([
				'id' => $aGroup[0],
				'name' => $aGroup[1],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);

		foreach ($this->aInstances as $aInstance)
			DB::table('instances')->insert([
				'id' => $aInstance[0],
				'name' => $aInstance[1],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);

		foreach ($this->aCompetitions as $aCompetition)
			DB::table('competitions')->insert([
				'id' => $aCompetition[0],
				'name' => $aCompetition[1],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);

		foreach ($this->aTeamsCompetitions as $aTeamCompetition)
			DB::table('teams_competitions')->insert([
				'team_id' => $aTeamCompetition[0],
				'competition_id' => $aTeamCompetition[1],
				'group_id' => $aTeamCompetition[2],
				'order' => $aTeamCompetition[3],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);
    }
}
