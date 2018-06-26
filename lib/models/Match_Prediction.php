<?php
/**
 * Match_Prediction class.
 *
 * @author Leandro Ibarra
 */
class Match_Prediction extends Model {
	/**
	 * @var object
	 */
	protected static $oInstance = null;

	/**
	 * @var string
	 */
	public $sTable = 'matches_predictions';

	/**
	 * @var string
	 */
	public $sViewMatches = 'view_matches';

	/**
	 * Retrieve instance of this class.
	 *
	 * @return Match_Prediction
	 */
	public static function getInstance() {
		if (!isset(self::$oInstance))
			self::$oInstance = new self();

		return self::$oInstance;
	}

	/**
	 * Retrieve matches predictions by filters.
	 *
	 * @param array $paFilters OPTIONAL
	 * @return array
	 */
	public function getByFilters($paFilters=array()) {
		return $this->oPdoWrapper->select($this->sTable, $paFilters);
	}

	/**
	 * Retrieve ranking of users.
	 *
	 * @param integer $piLimit OPTIONAL
	 * @return array $aPositions
	 */
	public function getUsersRanking($piLimit=null) {
		$aPositions = array();

		foreach (User::getInstance()->getWithPasswordNotNull() as $iKey=>$aUser) {
			// Validate limit of users in ranking
			if (!is_null($piLimit) && $piLimit<$iKey+1)
				break;

			$aPositions[] = array_merge(
				$this->getStatisticsByUser($aUser['id']),
				array(
					'id_user' => $aUser['id'],
					'nick' => $aUser['nick']
				)
			);
		}

		foreach ($aPositions as $iKey=>$aPosition) {
			$aPoints[$iKey] = $aPosition['points'];
			$aPredictions[$iKey] = $aPosition['predictions'];
		}

		// Sort by points and predictions
		array_multisort($aPoints, SORT_DESC, $aPredictions, SORT_ASC, $aPositions);

		return $aPositions;
	}

	/**
	 * Retieve statistics of predictions belonging to an user.
	 *
	 * @param integer $piIdUser
	 * @return array $aStatistics
	 */
	public function getStatisticsByUser($piIdUser) {
		$aStatistics = array(
			'total_matches' => 0,
			'finished_matches' => 0,
			'points' => 0, // User points
			'total_points' => 0, // Finished matches points summary
			'predictions' => 0, // User predictions
			'hits' => 0, // User hited predictions
			'failures' => 0, // User failed predictions
			'accuracy' => 0 // User accuracy
		);

		foreach ($this->oPdoWrapper->select($this->sViewMatches) as $aMatch) {
			$aStatistics['total_matches']++;
			$aStatistics['total_points'] += $this->aPointsByInstance[$aMatch['id_instance']];

			$aMatchPrediction = $this->getByFilters(array(
				'id_match_schedule' => $aMatch['id'],
				'id_user' => $piIdUser
			));

			if ((bool) $aMatchPrediction) {
				if (!is_null($aMatch['result'])) {
					$aStatistics['finished_matches']++;

					if ($aMatchPrediction[0]['result'] == $aMatch['result']) {
						$aStatistics['points'] += $this->aPointsByInstance[$aMatch['id_instance']];

						$aStatistics['hits']++;
					} else {
						$aStatistics['failures']++;
					}
				}

				$aStatistics['predictions']++;
			}
		}

		$aStatistics['accuracy'] = round(($aStatistics['hits']*100) / $aStatistics['finished_matches']);

		return $aStatistics;
	}

	/**
	 * Retieve hits and failures belonging to an user.
	 *
	 * @param integer $piIdUser
	 * @return array $aPredictions
	 */
	public function getHitsAndFailuresByUser($piIdUser) {
		$aPredictions = array(
			'hits' => array(),
			'failures' => array()
		);

		foreach (Match_Schedule::getInstance()->getLastMatches() as $aMatch) {
			if (!is_null($aMatch['result'])) {
				$aPrediction = $this->getByFilters(array(
					'id_match_schedule' => $aMatch['id'],
					'id_user' => $piIdUser
				));

				if ((bool) $aPrediction) {
					$aData = array_merge(
						$aMatch,
						array('prediction_result'=>$aPrediction[0]['result'])
					);

					if ($aPrediction[0]['result'] == $aMatch['result'])
						$aPredictions['hits'][] = $aData;
					else
						$aPredictions['failures'][] = $aData;
				}
			}
		}

		return $aPredictions;
	}

	/**
	 * Update match prediction info.
	 *
	 * @param array $paData (reference)
	 * @return array $paData
	 */
	public function update(&$paData) {
		$this->sanitizeData($paData);

		$this->validate($paData, 'update');

		if ((bool) $this->getByFilters(array(
			'id_match_schedule' => $paData['id_match_schedule'],
			'id_user' => $paData['id_user']
		)))
			$this->oPdoWrapper->update($this->sTable, $paData, array(
				'id_match_schedule' => $paData['id_match_schedule'],
				'id_user' => $paData['id_user']
			));
		else
			$this->oPdoWrapper->insert($this->sTable, $paData);

		return $paData;
	}

	/**
	 * Validates match prediction data.
	 *
	 * @param array $paData
	 * @param string $psType OPTIONAL
	 * @return boolean
	 * @throws Match_Prediction_Exception
	 */
	public function validate(&$paData, $psType='update') {
		$aErrors = array();

		$aMatchSchedule = Match_Schedule::getInstance()->getByFilters(array('id'=>$paData['id_match_schedule']));

		if (!(bool) $aMatchSchedule) {
			$aErrors['id_match_schedule'] = 'Match schedule ID is not valid';
		} else {
			if ($aMatchSchedule[0]['datetime'] < $this->convertDateAtomToGMT(date('Y-m-d\TH:i:sP')))
				$aErrors['id_match_schedule'] = 'Datetime has expired';
			else
				$paData['aMatchSchedule'] = $aMatchSchedule[0];
		}

		if (
			!(bool) $aErrors['id_match_schedule'] &&
			(
				!in_array($paData['result'], array('home', 'draw', 'away')) ||
				($aMatchSchedule[0]['id_instance']>1 && $paData['result']=='draw')
			)
		)
			$aErrors['result'] = 'Result is not valid';
		else
			$paData['result'] = strtolower($paData['result']);

		$aErrors = $this->recursiveArrayFilter($aErrors);

		if (!empty($aErrors))
			throw new Match_Prediction_Exception('Please validate data.', $aErrors);

		return true;
	}
}

class Match_Prediction_Exception extends Model_Exception {}