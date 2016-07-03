<?php

/**
 * Main Controller Engine
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Core
 * @version 1.0.1
*/

namespace Core;

use Core\View;

/**
 * Main Controller Engine Class
 * 
*/
class Controller {

    /**
     * @var string $view The view HTML result.
    */
	protected $view;

    /**
     * @var string $layout The layout View File used in the Application.
    */
	protected $layout 			= 'LayoutAdmin';
	
    /**
     * @var object $session The session object.
    */
	protected $session 			= null;

    /**
     * @var object $cookie The cookie object.
    */
	protected $cookie 			= null;
	
    /**
     * @var array $loggedUser The information of logged user.
    */
	protected $loggedUser 		= null;
	
    /**
     * @var array $get The data from GET method.
    */
	protected $get  			= null;
	
    /**
     * @var array $post The data from POST method.
    */
	protected $post 			= null;
	
    /**
     * @var array $breadcrumb The breadcrumb data.
    */
	protected $breadcrumb		= null;

    /**
     * The main setup of the Application.
     * 
     * @return null
    */
	public function __construct() {

		$this->controllerName 	= substr(basename(CONTROLLER_NAME), 0, -10);
		$this->actionName 		= ACTION_NAME;

		$this->view = new View;


		$this->get  = (Config::get('modules')['String']) ? \Application\Services\StringsService::escapeRecursive($_GET)  : $_GET;
		$this->post = (Config::get('modules')['String']) ? \Application\Services\StringsService::escapeRecursive($_POST) : $_POST;

		$_GET  = [];
		$_POST = [];

		define('CURRENT_PAGE', $this->get('page', 1));

		if (php_sapi_name() !== 'cli') {

			if (Config::get('modules')['Log']) {
				if (substr($this->actionName, -4) == 'Exec' && substr($this->controllerName, -4) != 'Logs') {
					$logData = (!count($this->post)) ? $this->get : $this->post;
					\Application\Services\LogService::log($this->controllerName . '-' . $this->actionName, json_encode($logData));
				}
			}

			if (Config::get('modules')['Session']) {
				$this->session 	= new \Application\Services\SessionService;
				$this->loggedUser = $this->session->user;
			}

			if (Config::get('modules')['Cookie']) {
				$this->cookie 	= new \Application\Services\CookieService;
			}

			if (is_null($this->loggedUser) && $this->controllerName != 'Login') { // not logged in and avoid loop redirect if already in IndexController

				$this->redirect(Config::get('path.web') . 'Login');

			} else {
				if (Config::get('modules')['AccessRight']) {
					\Application\Services\AccessRightsService::checkRights($this->controllerName, $this->actionName);
				}
			}
		}
	}

    /**
     * Renders View data of the Current Page.
     * 
     * @param string $view View Filename that you want to load
     * @param string|int|float|array|object $data Data passed to the View. If its array or object it will be splitted in multiple variables and passed, otherwise it will be passed directly.
     * @return null Outputs the final HTML Content.
    */
	protected function render($view, $data) {

		if (!isset($data['pageTitle'])) {
			$data['pageTitle'] = 'Page title is undefined';
		}

		$globalData = [
			'controllerName' 	=> $this->controllerName,
			'actionName' 		=> $this->actionName,
			'breadcrumb' 		=> $this->breadcrumb,
		];

		if (Config::get('modules')['Session']) {
			$globalData['loggedUser'] 	= $this->loggedUser;
			$globalData['session'] 		= $this->session;
			$globalData['flashMessage'] = $this->session->flash->message;
			$globalData['flashSuccess'] = $this->session->flash->success;
		}

		$data = array_merge($data, $globalData);

		$data['pageCss'] = (file_exists(dirname(__FILE__) . '/../Public/Assets/Css/Pages/' . $view . '.css')) ? '<link rel="stylesheet" type="text/css" media="screen" href="' . Config::get('path.web') . 'Assets/Css/Pages/' . $view . '.css">' : '<!-- File ' . $view . '.css couldn\'t be found. -->';
		$data['pageJs']  = (file_exists(dirname(__FILE__) . '/../Public/Assets/Js/Pages/' . $view . '.js')) ? '<script type="text/javascript" src="' . Config::get('path.web') . 'Assets/Js/Pages/' . $view . '.js"></script>' : '<!-- File ' . $view . '.js couldn\'t be found. -->';

		echo $this->view->load($this->layout, array_merge($data, [
			'pageContent' => $this->view->load($view, $data),
		]));
	}

    /**
     * Renders a Response in a JSon Format.
     * 
     * @param string|int|float|array|object $data Data passed to the View. If its array or object it will be splitted in multiple variables and passed, otherwise it will be passed directly.
     * @param cont $JSonMask JSon Mask which you want to apply. Default is JSON_FORCE_OBJECT.
     * @return null Outputs the final JSon Content.
    */
	protected function renderJson($data, $JSonMask = JSON_FORCE_OBJECT) {
		header('Content-Type: application/json');
		echo json_encode($data, $JSonMask);
	}

    /**
     * Redirect to a specific location.
     * 
     * @param string $location The location where do you want to redirect.
     * @return null
    */
	protected function redirect($location){
		header('location:' . $location);
		die;
	}

    /**
     * In case a Controller does not exist an error will be outputed and the execution halted.
     * 
     * @param mixed $p1 Argument Name
     * @param mixed $p2 Argument Value
     * @todo Use Exception instead die.
     * @return null If executed an error will be outputed and the execution halted.
    */
	public function __call($p1, $p2){
		die(sprintf('Action <strong>%s</strong> of controller <strong>%s</strong> it appears does not exist.', $p1, substr(get_class($this), 12)));
	}

    /**
     * Returns the $_GET array data
     * 
     * @param string $var The index desired from the $_GET SuperGlobal
     * @param string $defaultValue The default value in case the index is not set.
     * @return string The value of the $_GET index.
    */
	protected function get($var, $defaultValue = '') {
		return (isset($this->get[$var])) ? $this->get[$var] : $defaultValue;
	}

    /**
     * Returns the $_POST array data
     * 
     * @param string $var The index desired from the $_POST SuperGlobal
     * @param string $defaultValue The default value in case the index is not set.
     * @return string The value of the $_POST index.
    */
	protected function post($var, $defaultValue = '') {
		return (isset($this->post[$var])) ? $this->post[$var] : $defaultValue;
	}
}