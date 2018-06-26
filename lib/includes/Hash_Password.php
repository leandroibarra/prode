<?php
/**
 * Hash_Password class.
 *
 * @author Leandro Ibarra
 */
class Hash_Password {
	/**
	 * Indicates that we will use the Blowfish algorithm.
	 *
	 * @var string
	 */
	private static $sBlow = '$2a';

	/**
	 * Cost param. Indicates that will run (10 => 2^10 = 1024 iterations).
	 *
	 * @var string
	 */
	private static $sCost = '$10';

	/**
	 * Generate a string of 22 characters size. Will be used to generate hash.
	 *
	 * @return string
	 */
	public static function getUniqueSalt() {
		return substr(sha1(mt_rand()), 0, 22);
	}

	/**
	 * Generate hash password.
	 *
	 * @param string $psPassword
	 * @return string
	 */
	public static function hash($psPassword) {
		return crypt($psPassword, self::$sBlow.self::$sCost.'$'.self::getUniqueSalt());
	}

	/**
	 * Compare hash password and password.
	 *
	 * @param stsing $psHash
	 * @param string $psPassword
	 * @return boolean
	 */
	public static function checkPassword($psHash, $psPassword) {
		$sFullSalt = substr($psHash, 0, 29);

		$sNewHash = crypt($psPassword, $sFullSalt);

		return ($psHash == $sNewHash);
	}
}
