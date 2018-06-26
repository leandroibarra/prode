<?php
/**
 * Match_Schedule class.
 *
 * @author Leandro Ibarra
 */
class Match_Schedule extends Model {
	/**
	 * @var object
	 */
	protected static $oInstance = null;

	/**
	 * @var string
	 */
	public $sTable = 'matches_schedules';

	/**
	 * @var string
	 */
	public $sViewMatches = 'view_matches';

	/**
	 * Retrieve instance of this class.
	 *
	 * @return Match_Schedule
	 */
	public static function getInstance() {
		if (!isset(self::$oInstance))
			self::$oInstance = new self();

		return self::$oInstance;
	}

	/**
	 * Retrieve matches schedule by filters.
	 *
	 * @param array $paFilters OPTIONAL
	 * @return array
	 */
	public function getByFilters($paFilters=array()) {
		return $this->oPdoWrapper->select($this->sTable, $paFilters);
	}

	/**
	 * Retrieve match by id and validate start datetime optionally.
	 *
	 * @param integer $piIdMatch
	 * @param boolean $psComparation OPTIONAL
	 * @return array
	 */
	public function getMatchById($piIdMatch, $psComparation=null) {
		$sSql = "
			SELECT *
			FROM {$this->sViewMatches}
			WHERE id = :id
		";

		$aWhere['id'] = $piIdMatch;

		if (!is_null($psComparation)) {
			switch ($psComparation) {
				case 'gt':
					// Greater than
					$sComparation = '>';
					break;
				case 'lt':
					// Less than
					$sComparation = '<';
					break;
				case 'eq':
					// Equal to
					$sComparation = '=';
					break;
			}

			$sSql .= "
				AND datetime {$sComparation} :datetime
			";

			$aWhere['datetime'] = $this->convertDateAtomToGMT(date('Y-m-d\TH:i:sP'));
		}

		return $this->oPdoWrapper->query($sSql, $aWhere);
	}

	/**
	 * Retieve today matches.
	 *
	 * @return array
	 */
	public function getTodayMatches() {
		return $this->oPdoWrapper->query(
			"
			SELECT *
			FROM {$this->sViewMatches}
			WHERE datetime LIKE '%".$this->convertDateAtomToGMT(
				date('Y-m-d\TH:i:sP'),
				'Y-m-d'
			)."%'
			ORDER BY datetime ASC
			"
		);
	}

	/**
	 * Retieve next matches.
	 *
	 * @return array
	 */
	public function getNextMatches() {
		return $this->oPdoWrapper->query(
			"
			SELECT *
			FROM {$this->sViewMatches}
			WHERE datetime > :datetime
			ORDER BY datetime ASC
			",
			array('datetime'=>$this->convertDateAtomToGMT(date('Y-m-d\TH:i:sP')))
		);
	}

	/**
	 * Retieve last matches.
	 *
	 * @return array
	 */
	public function getLastMatches() {
		return $this->oPdoWrapper->query(
			"
			SELECT *
			FROM {$this->sViewMatches}
			WHERE datetime < :datetime
			ORDER BY datetime DESC
			",
			array('datetime'=>$this->convertDateAtomToGMT(date('Y-m-d\TH:i:sP')))
		);
	}
}

class Match_Schedule_Exception extends Model_Exception {}