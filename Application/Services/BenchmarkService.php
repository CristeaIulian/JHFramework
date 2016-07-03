<?php

/**
 * Benchmark Service tracks how much time it takes to load a page or a portion of it
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

/**
 * Benchmark Service Class tracks how much time it takes to load a page or a portion of it
 * 
*/
class BenchmarkService {

	/**
	 * @var float $startTime The exact time when the benchmark has started
	*/
	private static $startTime = null;

	/**
	 * Set the start time when the benchmark starts
	 * 
	 * @return null
	*/
	public static final function start() {

		self::$startTime = self::_microtimeFloat();
	}

	/**
	 * Get timing after a while or at the end of the page load
	 * 
	 * @return float The exact time when you make the check
	*/
	public static final function test() {
		return round(self::_microtimeFloat() - self::$startTime, 3);
	}

	/**
	 * Calculates the exact timing of the current datetime
	 * 
	 * @return float The exact current datetime
	*/
	private static final function _microtimeFloat() {
	    list($usec, $sec) = explode(" ", microtime());
	    return ((float)$usec + (float)$sec);
	}
}