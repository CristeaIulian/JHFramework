<?php

/**
 * DB Singleton
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Core
 * @version 1.0.1
*/

namespace Core;

/**
 * DB Singleton Class
 * 
*/
class DB
{
    /**
     * resources $instance The DB Connection Singleton Instance
    */
    private static $instance = [];

    /**
     * Get the DB Connection Instance
     * 
     * @param string $dbType Database Connection type. Eg: master, slave, or any custom connection.
     * @return resources Instance of database connection. 
    */
    public static function getInstance($dbType) {

        if (!isset(static::$instance[$dbType])) {

            static::$instance[$dbType] = mysqli_connect(Config::get('db.types.' . $dbType . '.hostname'), Config::get('db.types.' . $dbType . '.username'), Config::get('db.types.' . $dbType . '.password'), Config::get('db.types.' . $dbType . '.database'));
        }
        
        return static::$instance[$dbType];
    }

    /**
     * DB Connection Constructor
     * 
     * @return null
    */
    protected function __construct() { }

    /**
     * Clone method is used in order to force developer to not clone this object
     *
     * @return null
    */
    private function __clone() { }

    /**
     * WakeUp method is used in order to force developer to not serialize this object
     * 
     * @return null
    */
    private function __wakeup() { }
}