<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	private $aTeams = [
		[1, 'ARG', 'Argentina', 'Argentina'],
		[2, 'AUS', 'Australia', 'Australia'],
		[3, 'BEL', 'Belgium', 'Bélgica'],
		[4, 'BRA', 'Brazil', 'Brasil'],
		[5, 'CHE', 'Switzerland', 'Suiza'],
		[6, 'COL', 'Colombia', 'Colombia'],
		[7, 'CRI', 'Costa Rica', 'Costa Rica'],
		[8, 'DEU', 'Germany', 'Alemania'],
		[9, 'DNK', 'Denmark', 'Dinamarca'],
		[10, 'EGY', 'Egypt', 'Egipto'],
		[11, 'ENG', 'England', 'Inglaterra'],
		[12, 'ESP', 'Spain', 'España'],
		[13, 'FRA', 'France', 'Francia'],
		[14, 'HRV', 'Croatia', 'Croacia'],
		[15, 'IRN', 'Iran', 'Irán'],
		[16, 'ISL', 'Iceland', 'Islandia'],
		[17, 'JPN', 'Japan', 'Japón'],
		[18, 'KOR', 'South Korea', 'Corea del Sur'],
		[19, 'MAR', 'Morocco', 'Marruecos'],
		[20, 'MEX', 'Mexico', 'México'],
		[21, 'NGA', 'Nigeria', 'Nigeria'],
		[22, 'PAN', 'Panama', 'Panamá'],
		[23, 'PER', 'Peru', 'Perú'],
		[24, 'POL', 'Poland', 'Polonia'],
		[25, 'PRT', 'Portugal', 'Portugal'],
		[26, 'RUS', 'Russia', 'Rusia'],
		[27, 'SAU', 'Saudi Arabia', 'Arabia Saudita'],
		[28, 'SEN', 'Senegal', 'Senegal'],
		[29, 'SRB', 'Serbia', 'Serbia'],
		[30, 'SWE', 'Sweden', 'Suecia'],
		[31, 'TUN', 'Tunisia', 'Túnez'],
		[32, 'URY', 'Uruguay', 'Uruguay'],
		[33, 'BOL', 'Bolivia', 'Bolivia'],
		[34, 'QAT', 'Qatar', 'Qatar'],
		[35, 'CHL', 'Chile', 'Chile'],
		[36, 'ECU', 'Ecuador', 'Ecuador'],
		[37, 'PRY', 'Paraguay', 'Paraguay'],
		[38, 'VEN', 'Venezuela', 'Venezuela']
	];

	private $aGroups = [
		[1, 'Group A', 'Grupo A'],
		[2, 'Group B', 'Grupo B'],
		[3, 'Group C', 'Grupo C'],
		[4, 'Group D', 'Grupo D'],
		[5, 'Group E', 'Grupo E'],
		[6, 'Group F', 'Grupo F'],
		[7, 'Group G', 'Grupo G'],
		[8, 'Group H', 'Grupo H']
	];

	private $aInstances = [
		[1, 'Group Phase', 'Fase de grupos'],
		[2, 'Round of 16', 'Octavos de final'],
		[3, 'Quarter-finals', 'Cuartos de final'],
		[4, 'Semi-finals', 'Semifinales'],
		[5, 'Play-off for third place', 'Partido por el tercer puesto'],
		[6, 'Final', 'Final']
	];

	private $aCompetitions = [
		[1, '2018 FIFA World Cup Russia', 'Copa Mundial de la FIFA Rusia 2018', 'fifa_world_cup_russia_2018.png'],
		[2, '2019 American Cup Brazil', 'Copa América Brasil 2019', 'conmebol_copa_america_brasil_2019.png']
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
		[28, 1, 8, 4],
		[4, 2, 1, 1],
		[33, 2, 1, 2],
		[38, 2, 1, 3],
		[23, 2, 1, 4],
		[1, 2, 2, 1],
		[6, 2, 2, 2],
		[27, 2, 2, 3],
		[34, 2, 2, 4],
		[32, 2, 3, 1],
		[36, 2, 3, 2],
		[17, 2, 3, 3],
		[35, 2, 3, 4]
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
				'name_en' => $aTeam[2],
				'name_es' => $aTeam[3],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);

		foreach ($this->aGroups as $aGroup)
			DB::table('groups')->insert([
				'id' => $aGroup[0],
				'name_en' => $aGroup[1],
				'name_es' => $aGroup[2],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);

		foreach ($this->aInstances as $aInstance)
			DB::table('instances')->insert([
				'id' => $aInstance[0],
				'name_en' => $aInstance[1],
				'name_es' => $aInstance[2],
				'created_at' => date('Y-m-d H:m:s'),
				'updated_at' => date('Y-m-d H:m:s')
			]);

		foreach ($this->aCompetitions as $aCompetition)
			DB::table('competitions')->insert([
				'id' => $aCompetition[0],
				'name_en' => $aCompetition[1],
				'name_es' => $aCompetition[2],
				'icon' => $aCompetition[3],
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
