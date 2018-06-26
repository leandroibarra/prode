<?php
/**
 * Team class.
 *
 * @author Leandro Ibarra
 */
class Team extends Model {
	/**
	 * @var object
	 */
	protected static $oInstance = null;

	/**
	 * @var string
	 */
	public $sTable = 'teams';

	/**
	 * Retrieve instance of this class.
	 *
	 * @return Team
	 */
	public static function getInstance() {
		if (!isset(self::$oInstance))
			self::$oInstance = new self();

		return self::$oInstance;
	}

	/**
	 * Retrieve teams by filters.
	 *
	 * @param array $paFilters OPTIONAL
	 * @return array
	 */
	public function getByFilters($paFilters=array()) {
		return $this->oPdoWrapper->select($this->sTable, $paFilters);
	}
}

class Team_Exception extends Model_Exception {}