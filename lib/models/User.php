<?php
/**
 * User class.
 *
 * @author Leandro Ibarra
 */
class User extends Model {
	/**
	 * @var object
	 */
	protected static $oInstance = null;

	/**
	 * @var string
	 */
	public $sTable = 'users';

	/**
	 * Retrieve instance of this class.
	 *
	 * @return User
	 */
	public static function getInstance() {
		if (!isset(self::$oInstance))
			self::$oInstance = new self();

		return self::$oInstance;
	}

	/**
	 * Retrieve users by filters.
	 *
	 * @param array $paFilters OPTIONAL
	 * @return array
	 */
	public function getByFilters($paFilters=array()) {
		return $this->oPdoWrapper->select($this->sTable, $paFilters);
	}

	/**
	 * Retrieve users with password not null.
	 *
	 * @return array
	 */
	public function getWithPasswordNotNull() {
		return $this->oPdoWrapper->query(
			"
			SELECT *
			FROM {$this->sTable}
			WHERE password IS NOT NULL
			"
		);
	}

	/**
	 * Authenticate an user by email and password.
	 *
	 * @param array $paData (reference)
	 * @param integer $piStep OPTIONAL
	 * @return array $paData
	 */
	public function authenticate(&$paData, $piStep=1) {
		$this->sanitizeData($paData);

		$this->validate($paData, 'authenticate_'.$piStep);

		return $paData;
	}

	/**
	 * Update user info.
	 *
	 * @param array $paData (reference)
	 * @return array $paData
	 */
	public function update(&$paData) {
		$this->sanitizeData($paData);

		$this->validate($paData, 'update');

		$this->oPdoWrapper->update($this->sTable, $paData, array('id'=>$paData['id_user']));

		return $paData;
	}

	/**
	 * Validates user data.
	 *
	 * @param array $paData
	 * @param string $psType OPTIONAL
	 * @return boolean
	 * @throws User_Exception
	 */
	public function validate(&$paData, $psType='authenticate_1') {
		$aErrors = array();

		switch ($psType) {
			case 'authenticate_1':
				if ($paData['email'] == '')
					$aErrors['email'] = 'Email is required';
				else if (!$this->validateEmail($paData['email']))
					$aErrors['email'] = 'Email is not valid';
				else {
					$aUser = $this->getByFilters(array('email'=>$paData['email']));

					if (!(bool) $aUser)
						$aErrors['email'] = 'Email is not valid';
					else
						$paData['aUser'] = $aUser[0];
				}

				break;
			case 'authenticate_2':
				if ($paData['password'] == '')
					$aErrors['password'] = 'Password is required';
				else if (strlen($paData['password']) < 6)
					$aErrors['password'] = 'Password is not valid';
				else {
					$aUser = $this->getByFilters(array('id'=>$paData['id_user']));

					if (!Hash_Password::checkPassword($aUser[0]['password'], $paData['password']))
						$aErrors['password'] = 'Password is not valid';
					else
						$paData['aUser'] = $aUser[0];
				}

				break;
			case 'update':
				if ($paData['nick'] == '')
					$aErrors['nick'] = 'Nick is required';
				else if (strlen($paData['nick']) < 6)
					$aErrors['nick'] = 'Nick is not valid';

				if ($paData['password'] == '')
					$aErrors['password'] = 'Password is required';
				else if (strlen($paData['password']) < 6)
					$aErrors['password'] = 'Password is not valid';

				if ($paData['confirm_password'] == '')
					$aErrors['confirm_password'] = 'Confirm password is required';
				else if (strlen($paData['confirm_password']) < 6)
					$aErrors['confirm_password'] = 'Confirm password is not valid';
				else if (!(bool) $aErrors['password'] && ($paData['password']!=$paData['confirm_password']))
					$aErrors['confirm_password'] = 'Passwords do not match';

				if (!(bool) $aErrors['password'] && !(bool) $aErrors['confirm_password'])
					$paData['password'] = Hash_Password::hash($paData['password']);

				break;
		}

		$aErrors = $this->recursiveArrayFilter($aErrors);

		if (!empty($aErrors))
			throw new User_Exception('Please validate data.', $aErrors);

		return true;
	}
}

class User_Exception extends Model_Exception {}