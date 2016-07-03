<?php

/**
 * Access Rights Service Check and setup user rights
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

use Application\Models\AccessRightsModel;

use Application\Services\SessionService;

/**
 * Access Rights Service Class Check and setup user rights
 * 
*/
class AccessRightsService {

    /**
     * @var array $allowedList Sections that are allowed and there is no check need it.
    */
	private static $allowedList = [
		'Index' => [
			'Index',
			'UpdateItemsPerPage',
			'Filter',
		],
		'Login' => [
			'Index',
			'Logout',
			'PasswordLost',
			'Login',
			'PasswordLostExec',
			'PasswordReset',
			'PasswordResetExec',
		],
	];

    /**
     * Check whether a user should have access to a section or not.
     *
     * @param string $controllerName The name of the controller.
     * @param string $actionName The name of the action.
     * @param bool $return If should return the status with a bollean. If set to false will directly halt the execution with a message.
     * @return bool|null Returns true/false if acess is available. Halts with a message if the access is restricted and the $return variable is set to false.
    */
	public static final function checkRights($controllerName, $actionName, $return = false) {

		$accessRights 	= self::_getRights();
		
		// check if belongs to exceptions list
		if (isset(self::$allowedList[$controllerName]) && in_array($actionName, self::$allowedList[$controllerName])) {
			return true;
		}

		if (!isset($accessRights[$controllerName], $accessRights[$controllerName][$actionName])) {
			if ($return) {
				return false;
			} else {
				die('Access Restricted');
			}
		}

		$session = new SessionService;

		if (!in_array($session->user['user_type'], $accessRights[$controllerName][$actionName]['users'])) {
			if ($return) {
				return false;
			} else {
				die('Access Restricted');
			}
		}

		if ($accessRights[$controllerName][$actionName]['ajax'] == 1 && !(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
			die('Access Restricted');
		}

		return true;
	}

    /**
     * Gets the available sections rights.
     *
     * @return array The list with sections rights.
    */
	private static final function _getRights() {
		
		$AccessRightsModel = new AccessRightsModel();
		$accessRightsResult = $AccessRightsModel->getAll();

		$accessRights = [];

		foreach ($accessRightsResult as $accessRight) {
			$accessRights[$accessRight->controller][$accessRight->action] = [
				'users' => json_decode($accessRight->users),
				'ajax' 	=> $accessRight->ajax,
			];
		}

		return $accessRights;
	}
}