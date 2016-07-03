<?php

/**
 * Users Services execute users operations
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

use Application\Models\UserTypeModel;

/**
 * Users Service Class execute users operations
 * The name of the class should be UserServices not UsersServices
 * 
*/
class UsersService {

	/**
	 * @var array $userTypes The list of user types kept for caching if is already taken
	*/
	private static $userTypes = null;

	/**
	 * Gets the list of existing user types
	 * 
	 * @return array The list with user types
	*/
	public static final function getUserTypes() {

		if (is_null(self::$userTypes)) {
	
			$userTypesResult = (new UserTypeModel)->db->getRows();

			foreach ($userTypesResult as $userType) {
				self::$userTypes[$userType->id] = $userType->account_type;
			}
		}

		return self::$userTypes;
	}
}