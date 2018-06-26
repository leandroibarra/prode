<?php
/**
 * Instance class.
 *
 * @author Leandro Ibarra
 */
class Instance extends Model {
	/**
	 * @var object
	 */
	protected static $oInstance = null;

	/**
	 * @var string
	 */
	public $sTable = 'instances';

	/**
	 * Retrieve instance of this class.
	 *
	 * @return Instance
	 */
	public static function getInstance() {
		if (!isset(self::$oInstance))
			self::$oInstance = new self();

		return self::$oInstance;
	}

	/**
	 * Retrieve instances by filters.
	 *
	 * @param array $paFilters OPTIONAL
	 * @return array
	 */
	public function getByFilters($paFilters=array()) {
		return $this->oPdoWrapper->select($this->sTable, $paFilters);
	}
}

class Instance_Exception extends Model_Exception {}