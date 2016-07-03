<?php

/**
 * Application Router
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Core
 * @version 1.0.1
*/

namespace Core;

/**
 * Application Router Class
 * 
*/
class Router {

    /**
     * @var string $controller Controller name
    */
	public static $controller 	= null;
    
    /**
     * @var string $action Action name
    */
	public static $action 		= null;
    
    /**
     * @var string $prefix Prefix Application. It is used in case the developer want to have the application in a folder not in root.
    */
	public static $prefix 		= null;
    
    /**
     * @var string $method HTTP Method
    */
	public static $method 		= null;

    /**
     * @var string $get GET method filled with arguments parsed by Router
    */
	public static $get 			= null;

    /**
     * Router Path Parser
     *
     * @todo Optimize foreach a little bit: __foreach ($routes as $routePath => $route) {__
     * 
     * @return array Controller name and Action Name
    */
	public static final function parsePath() {

		if (self::$controller == null) {

			self::$prefix = Config::get('path.web.prefix');

			$routes = require_once(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'Routes.php';

			if (!is_array($routes)){
				die('Routes structure must be an array.');
			}

			$fullURL = Config::get('path.protocol') . '://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			$routeURL = str_replace(Config::get('path.web'), '', $fullURL);

			if (isset($routes[$routeURL])){

				self::$controller 	= $routes[$routeURL][0];
				self::$action 		= (isset($routes[$routeURL][1])) ? $routes[$routeURL][1] : 'Index';
				self::$method 		= (isset($routes[$routeURL][2])) ? $routes[$routeURL][2] : 'GET';

			} else {

				$routeURLArr = explode('/', $routeURL);

				foreach ($routes as $routePath => $route) {

					if (strpos($routePath, '{') && strpos($routePath, '}')) { // match with possible variables

						$routePathArr = explode('/', $routePath);

						$matchesAll = true;
						
						for ($i=0; $i<count($routeURLArr); $i++){

							if (!isset($routePathArr[$i]) || count($routeURLArr[$i]) != count($routePathArr[$i])){
								$matchesAll = false;
								break 1;
							}

							if ($routeURLArr[$i] == $routePathArr[$i]){
								// exact match
							} else if (strpos($routePathArr[$i], '{') !== false && strpos($routePathArr[$i], '}') !== false) { // match on vars

								$_GET[substr($routePathArr[$i], 1, -1)] 		= addslashes($routeURLArr[$i]); // we'll try to not use this
								self::$get[substr($routePathArr[$i], 1, -1)] 	= $routeURLArr[$i];

							} else { // no match
								$matchesAll = false;
								break 1;
							}
						}

						if ($matchesAll){
							$matchRoute = $route;
							break 1;
						}
					}
				}

				if ($matchesAll){
					self::$controller 	= $matchRoute[0];
					self::$action 		= (isset($matchRoute[1])) ? $matchRoute[1] : 'Index';
					self::$method 		= (isset($matchRoute[2])) ? $matchRoute[2] : 'GET';
				} else {

					self::$controller 	= 'IndexController';
					self::$action 		= 'Index';
					self::$method 		= 'GET';
				}
			}

			if (self::$method != $_SERVER['REQUEST_METHOD']) {

				if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

					$data = array(
						'success' => false,
						'message' => 'Invalid request method',
					);

					header('Content-Type: application/json');
					echo json_encode($data, JSON_FORCE_OBJECT);

					die;

				} else {
					die('Invalid request method');
				}
			}
		}

		return [
			self::$controller,
			self::$action,
		];
	}
}