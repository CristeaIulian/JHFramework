<?php

/**
 * Log Service is used to log user actions while navigate throw the application
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

use Application\Models\LogModel;

/**
 * Log Service Class is used to log user actions while navigate throw the application
 * 
*/
class LogService {

	/**
	 * Trace user actions
	 * 
	 * @param string $action Action the user made like: insert, update, delete or any other custom action.
	 * @param string $details Some optional details that you want to add.
	 * @return null
	*/
	public static function log($action, $details = '') {

		$sessionService = (new SessionService);

		$data = [
			'action' => $action,
			'details' => $details,
			'user_id' => (is_null($sessionService->user)) ? 0 : $sessionService->user['id'],
		];

		$LogModel = new LogModel();
		$LogModel->insert($data);
	}
}