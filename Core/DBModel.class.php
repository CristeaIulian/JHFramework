<?php

/**
 * DB Model Singleton
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Core
 * @version 1.0.1
*/

namespace Core;

/**
 * DB Model Class
 * 
*/
class DBModel {

    /**
     * array $relations Relations (joins) used in queries.
    */
	public $relations = [];

    /**
     * DB Connection Constructor used to initialize the connection
     * 
     * @return null
    */
	public function __construct() {

		$this->conn();
	}

    /**
     * Connection Instantiation
     * 
     * @param string $dbType Database Connection type. Eg: master, slave, or any custom connection.
     * @throws \Exception table property is not defined or not accesible.
     * @return null
    */
	protected function conn($dbType = '') {

		if (!isset($this->table)) {
			throw new \Exception('table property is not defined or not accesible.', 1);
		}

		$this->db = new ORM(Config::get('db.type.default'), $this->table, $this->relations);
	}
}