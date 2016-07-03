<?php

/**
 * Session Service Normal and Flash Sessions manipulation
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

/**
 * Session Service Class Normal Sessions manipulation
 * 
*/
class SessionService {

    /**
     * @var object $flash The dependency injection object for Flash Session Variables.
    */
	public $flash = null;

    /**
     * Scans for tables integrity.
     *
     * @return null If errors are encoutered it will output the list of missing tables.
    */
	public function __construct() {
		$this->flash = new SessionFlashService;
	}

    /**
     * Sets a session.
     *
     * @param string $session The name of the session.
     * @param string $value The value of the session.
     * @todo Use Exceptions instead of die.
     * @return null
    */
	private final function set($session = null, $value = null) {

		if (empty($session)) {
			die('Session setter name must be defined and not empty.');
		}

		if (is_null($value)) {
			die('Session <strong>' . $session . '</strong> must have a value.');
		}

		$_SESSION['normal'][$session] = $value;
	}

    /**
     * Gets a session.
     *
     * @param string $session The name of the session.
     * @todo Use Exceptions instead of die.
     * @return string|null Session value if exists, null otherwise.
    */
	private final function get($session) {

		if (empty($session)) {
			die('Session getter name must be defined and not empty.');
		}

		return (isset($_SESSION['normal'][$session])) ? $_SESSION['normal'][$session] : null;
	}

    /**
     * Removes a session.
     *
     * @param string $session The name of the session.
     * @todo Use Exceptions instead of die.
     * @return null
    */
	public final function remove($session = null) {

		if (empty($session)) {
			die('Session remove name must be defined and not empty.');
		}

		unset($_SESSION['normal'][$session]);
	}

    /**
     * Removes all sessions.
     *
     * @return null
    */
	public final function destroy() {
		session_destroy();
	}

    /**
     * Sets a session.
     *
     * @param string $session The name of the session.
     * @param string $value The value of the session.
     * @return null
    */
	public function __set($session, $value) {
		return $this->set($session, $value);
	}

    /**
     * Gets a session.
     *
     * @param string $session The name of the session.
     * @return string|null Session value if exists, null otherwise.
    */
	public function __get($session) {
		return $this->get($session);
	}
}

/**
 * Session Flash Service Class Flash Sessions manipulation
 * 
*/
class SessionFlashService {

    /**
     * Sets a flash session.
     *
     * @param string $session The name of the flash session.
     * @param string $value The value of the flash session.
     * @todo Use Exceptions instead of die.
     * @return null
    */
	private final static function set($session, $value = null) {

		if (empty($session)) {
			die('Session flash setter name must be defined and not empty.');
		}

		if (is_null($value)) {
			die('Session flash <strong>' . $session . '</strong> must have a value.');
		}

		$_SESSION['flash'][$session] = $value;
	}

    /**
     * Gets a flash session.
     *
     * @param string $session The name of the flash session.
     * @todo Use Exceptions instead of die.
     * @return string|null Flash Session value if exists, null otherwise.
    */
	private final static function get($session) {
		
		if (empty($session)) {
			die('Session flash getter name must be defined and not empty.');
		}

		if (!isset($_SESSION['flash'][$session])) {
			return null;
		}

		$sessionValue = $_SESSION['flash'][$session];
		unset($_SESSION['flash'][$session]);
		return $sessionValue;
	}

    /**
     * Sets a flash session.
     *
     * @param string $session The name of the flash session.
     * @param string $value The value of the flash session.
     * @return null
    */
	public function __set($session, $value) {
		return $this->set($session, $value);
	}

    /**
     * Gets a flash session.
     *
     * @param string $session The name of the flash session.
     * @return string|null Session value if exists, null otherwise.
    */
	public function __get($session) {
		return $this->get($session);
	}
}