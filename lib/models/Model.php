<?php
/**
 * Model class.
 *
 * @author Leandro Ibarra
 */
class Model {
	/**
	 * @var object
	 */
	protected static $oInstance = null;

	/**
	 * @var array
	 */
	public $aPointsByInstance = array(
		1 => 1,
		2 => 4,
		3 => 6,
		4 => 8,
		5 => 10,
		6 => 10
	);

	/**
	 * @var PDO_Wrapper
	 */
	public $oPdoWrapper;

	/**
	 * Retrieve instance of this class.
	 *
	 * @return Model
	 */
	public static function getInstance() {
		if (!isset(self::$oInstance))
			self::$oInstance = new self();

		return self::$oInstance;
	}

	public function __construct() {
		if (!isset($this->oPdoWrapper))
			$this->oPdoWrapper = PDO_Wrapper::getInstance();
	}

	/**
	 * Applies array_filter to an array recursively.
	 *
	 * @param array $paArray
	 * @return array $paArray
	 */
	protected function recursiveArrayFilter($paArray) {
		foreach ($paArray as &$mValue)
			if (is_array($mValue))
				$mValue = $this->recursiveArrayFilter($mValue);

		return array_filter($paArray);
	}

	/**
	 * Convert datetime with DATE_ATOM format to Greenwich datetime, with specified format.
	 *
	 * @param string $psDateTime
	 * @param string $psFormat OPTIONAL
	 * @return string
	 */
	public function convertDateAtomToGMT($psDateTime, $psFormat='Y-m-d H:i:s') {
		$oDateTime = new DateTime($psDateTime);

		$aSigns = array(
			'+' => '-',
			'-' => '+'
		);

		// Obtains difference to Greenwich time (GMT) with colon between hours and minutes
		$sOffset = $oDateTime->format('P');

		// Obtains sign from the difference to GMT
		$sOffsetSign = $sOffset[0];

		// Obtains hours and minutes from the difference to GMT
		list($iHour, $iMinute) = explode(':', str_replace($sOffsetSign, '', $sOffset));

		// Inverts signs of hours and minutes
		$iHour = $aSigns[$sOffsetSign].$iHour;
		$iMinute = $aSigns[$sOffsetSign].$iMinute;

		// Converts the source datetime to GMT +00:00
		$oDateTime->modify("{$iHour} hour {$iMinute} minute");

		// Returns source datetime with necessary format
		return $oDateTime->format($psFormat);
	}

	/**
	 * Sanitize data of recordset applying a set of functions.
	 *
	 * @param array $paData (reference)
	 * @param array $paFieldsWithHtml OPTIONAL
	 * @param bool  $bSkipKeys OPTIONAL 
	 */
	protected function sanitizeData(&$paData, $paFieldsWithHtml=array(), $bSkipKeys=false) {
		// Remove whitespace from the beginning and end in each field
		$sFunction = 'trim';

		foreach ($paData as $iKey=>$mValue) {
			if (is_array($mValue)) {
				$this->sanitizeData($paData[$iKey], $paFieldsWithHtml, true);
			} else {
				$sValue = $sFunction($mValue);

				// Convert special characters to HTML entities and quote string with slashes
				if ((bool) in_array($iKey, (array) $paFieldsWithHtml) || $bSkipKeys)
					$sValue = addslashes(htmlspecialchars($sValue));

				$paData[$iKey] = $sValue;
			}
		}
	}

	/**
	 * Decode data of recordset applying a set of functions.
	 *
	 * @param array $paData (reference)
	 * @param array $paFieldsWithHtml OPTIONAL
	 * @param bool  $bSkipKeys OPTIONAL 
	 */
	protected function decodeData(&$paData, $paFieldsWithHtml=array(), $bSkipKeys=false) {
		foreach ($paData as $iKey=>$mValue) {
			if (is_array($mValue)) {
				$this->decodeData($paData[$iKey], $paFieldsWithHtml, true);
			} else {
				// Decode HTML entities to special characters and strip string with quote slashes
				if ((bool) in_array($iKey, $paFieldsWithHtml) || $bSkipKeys) {
					$sValue = stripslashes(htmlspecialchars_decode($mValue));

					// Convert all HTML entities to their applicable characters
					$paData[$iKey] = html_entity_decode($sValue);
				}
			}
		}
	}

	/**
	 * Validates that the email well written.
	 *
	 * Unicode
	 * \x{00C0}-\x{017E} = U+00C0-U+017E = À-ž
	 *
	 * @param string $psEmail
	 * @return boolean $bResult
	 */
	protected function validateEmail($psEmail) {
		$bResult = false;

		if (preg_match('/^([a-zA-Z\x{00C0}-\x{017E}0-9]+[a-zA-Z\x{00C0}-\x{017E}0-9!#$%&\'*+\/=?^_`{|}~-]*(\.[a-zA-Z\x{00C0}-\x{017E}0-9!#$%&\'*+\/=?^_`{|}~-]+)*|\x22[a-zA-Z\x{00C0}-\x{017E}0-9]+[a-zA-Z\x{00C0}-\x{017E}0-9!#$%&\'*+\/=?^_`{|}~-]*(\.+[a-zA-Z\x{00C0}-\x{017E}0-9!#$%&\'*+\/=?^_`{|}~-]+)*\x22)@[a-z0-9]+(-[a-z0-9]+)*(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/u', $psEmail) == 1)
			$bResult = true;

		return $bResult;
	}
}


class Model_Exception extends Exception {
	private $aErrors = null;

	public function __construct($psMessage=null, $paErrors=null) {
		if (!is_null($paErrors))
			$this->aErrors = (array) $paErrors;

		parent::__construct($psMessage);
	}

	public function getErrors() {
		return $this->aErrors;
	}
}