<?php

/**
 * DB ORM ACTIVE RECORD
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Core
 * @version 1.0.1
*/

namespace Core;

/**
 * DB ORM ACTIVE RECORD Class
 * 
 * Relations Example:
 *
 *		'relation_name' => [
 *			'table' => 'TABLE_NAME',
 *			'on'	=> 'RELATION_BETWEEN_TABLES_THROUGH_COLUMNS',
 *			'join' 	=> 'left' // left/right/cross/etc | default:left
 *		],
 *
*/
class ORM {

	/**
	 * @var object $model Stores data for insert and update.
	*/
	public $model;

	/**
	 * @todo This property should be $_conn.
	 * @var object $conn The DB connection.
	*/
	private $conn;

	/**
	 * @todo This property should be $_table.
	 * @var string $table The current table.
	*/
	private $table;

	/**
	 * @todo This property should be $_relations.
	 * @var array $relations Contains relations used for joins.
	*/
	private $relations;

	/**
	 * @var array $_join Contains joins.
	*/
	private $_join;

	/**
	 * @var array $_columns Contains query columns.
	*/
	private $_columns = [];

	/**
	 * @var array $_where Contains WHERE query filter.
	*/
	private $_where = [];

	/**
	 * @var array $_group Contains query grouping.
	*/
	private $_group = [];

	/**
	 * @var array $_order Contains query ordering.
	*/
	private $_order = [];

	/**
	 * @var string $_limit Contains query limits.
	*/
	private $_limit = '';

    /**
     * Magic __set method exist to lock developer adding other methods than existing ones.
     * 
     * @param string $var The argument name.
     * @param string $value The value of the argument.
     * @todo Check if this is better to be protected instead public.
     * @throws \Exception 'Unsupported $var property setter. Please see documentation.
     *
     * @return null
    */
	public function __set($var, $value) {
		throw new \Exception('Unsupported ' . $var  . ' property setter. Please see documentation.', 1);
	}

    /**
     * Magic __get method exist to lock developer reading other methods than existing ones.
     * 
     * @param string $var The argument name.
     * @todo Check if this is better to be protected instead public.
     * @throws \Exception 'Unsupported $var property getter. Please see documentation.
     *
     * @return null
    */
	public function __get($var) {
		throw new \Exception('Unsupported ' . $var  . ' property getter. Please see documentation.', 1);
	}

    /**
     * Constructor initialize connection, setup default table, relations and active model.
     * 
     * @param string $dbType Database Connection type. Eg: master, slave, or any custom connection.
     * @param string $table Current table in use.
     * @param array $relations Relations used for queries.
     *
     * @return null
    */
	public function __construct($dbType, $table, $relations) {

		$this->conn 		= DB::getInstance($dbType);

		$this->table 		= $table;
		$this->relations 	= $relations;

		$this->model 		= new \stdClass;
	}

    /**
     * Where filter applied to the query. Can be called multiple times for the same query. The filter will be aggregated.
     * 
     * Example: __$this->db->where("field = 'value'");__
	 *
     * @param string $where Where filter applied to the query.
     *
     * @return null
    */
	public final function where($where) {
		$this->_where[] = $where;
	}

    /**
     * Setup columns used in the query. Not calling this method it will load all columns "*". Also callin this method multiple times it will aggregate the result.
     *
     * Example: __$this->db->columns('id, name');__
     * 
     * @param string $columns Columns used in the query.
     *
     * @return null
    */
	public final function columns($columns) {
		$this->_columns[] = $columns;
	}

    /**
     * Grouping used in the query.
     * 
     * @param string $group Groups used in the query.
     *
     * @return null
    */
	public final function group($group) {
		$this->_group[] = $group;
	}

    /**
     * Query Ordering.
     * 
     * @param string $order Order used in the query.
     *
     * @return null
    */
	public final function order($order) {
		$this->_order[] = $order;
	}

    /**
     * Query Limitations. Calling multiple times it will take the last value.
     *
     * Example: __$this->db->limit(2);__
     * 
     * @param string $limit Limits applied to the query.
     *
     * @return null
    */
	public final function limit($limit) {
		$this->_limit = $limit;
	}

	/**
     * Adds Query join relations.
     * 
     * Example: __$this->db->join('users\_\_logs');__ _single join relation_
     *
	 * Example: __$this->db->join(array('users\_\_projects\_inits\_users', 'users\_\_logs'));__ _multiple joins relations_
     *
     * @param string|array $join Passing it as a string it will add a single relation for joining. Passing it as array you can add one or more join relations.
     *
     * @return null
    */
	public final function join($join) {
		
		if (is_array($join)){
			if (is_array($this->_join)){
				$this->_join = array_merge($this->_join, $join);
			} else {
				$this->_join = $join;
			}
			
		} else {
			$this->_join[] = $join;
		}
	}

	/**
     * Gets all rows and columns of the query.
     *
	 * Example: __$this->db->getRows();__
     * 
     * @return object Contains the result as Object.
    */
	public final function getRows() {

		$query  = "SELECT " . ((!empty($this->_columns)) ? implode(', ', $this->_columns) : '*') . " FROM " . $this->table . " AS t ";

		if (!is_null($this->_join)){
			$query .= ' ' . implode(' ', $this->_getJoins()) . ' ';
		}

		if (!empty($this->_where)){
			$query .= " WHERE " . implode(' AND ', $this->_where);
		}

		if (!empty($this->_group)){
			$query .= " GROUP BY " . implode(', ', $this->_group);
		}

		if (!empty($this->_order)){
			$query .= " ORDER BY " . implode(', ', $this->_order);
		}

		if (!empty($this->_limit)){
			$query .= " LIMIT " . $this->_limit;
		}

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$result = array();

		while ($row = mysqli_fetch_object($rs)){
			$result[] = $row;
		}

		$this->_cleanupAttributes();

		return $result;
	}

	/**
     * Gets a single row.
     *
	 * Example: __$this->db->getRow();__
     * 
     * @throws \Exception Multiple rows selected. Please verify.
     *
     * @return object Contains the result as Object.
    */
	public final function getRow() {

		$query  = "SELECT " . ((!empty($this->_columns)) ? implode(', ', $this->_columns) : '*') . " FROM " . $this->table . " AS t ";

		if (!is_null($this->_join)){
			$query .= ' ' . implode(' ', $this->_getJoins()) . ' ';
		}

		if (!empty($this->_where)){
			$query .= " WHERE " . implode(' AND ', $this->_where);
		}

		if (!empty($this->_group)){
			$query .= " GROUP BY " . implode(', ', $this->_group);
		}

		if (!empty($this->_order)){
			$query .= " ORDER BY " . implode(', ', $this->_order);
		}

		if (!empty($this->_limit)){
			$query .= " LIMIT " . $this->_limit;
		}

		$rs = mysqli_query($this->conn, $query);

		if (mysqli_num_rows($rs) > 1) {
			throw new \Exception("Multiple rows selected. Please verify.", 1);
		}

		$this->_checkError();

		$this->_cleanupAttributes();

		return mysqli_fetch_object($rs);
	}

	/**
     * Gets all rows with but a single column from them. If you specify more than one columns or columns() method is not applied it will extract the first column of the query.
     * 
	 * Example: __$this->db->getColumn();__
	 *
     * @return object Contains the result as Object.
    */
	public final function getColumn() {

		$query  = "SELECT " . ((!empty($this->_columns)) ? implode(', ', $this->_columns) : '*') . " FROM " . $this->table . " AS t ";

		if (!is_null($this->_join)){
			$query .= ' ' . implode(' ', $this->_getJoins()) . ' ';
		}

		if (!empty($this->_where)){
			$query .= " WHERE " . implode(' AND ', $this->_where);
		}

		if (!empty($this->_group)){
			$query .= " GROUP BY " . implode(', ', $this->_group);
		}

		if (!empty($this->_order)){
			$query .= " ORDER BY " . implode(', ', $this->_order);
		}

		if (!empty($this->_limit)){
			$query .= " LIMIT " . $this->_limit;
		}

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$result = array();

		while ($row = mysqli_fetch_assoc($rs)){
			$result[] = array_shift($row);
		}

		$this->_cleanupAttributes();

		return $result;
	}

    /**
     * Gets a single column from a single row. Tipicaly used from MAX, COUNT or other functions in this area. If you specify more than one columns or columns() method is not applied it will extract the first column of the query.
     * 
	 * Example: __$this->db->getOne();__
	 *
     * @throws \Exception Multiple rows selected. Please verify.
     *
     * @return null
    */
	public final function getOne() {

		$query  = "SELECT " . ((!empty($this->_columns)) ? implode(', ', $this->_columns) : '*') . " FROM " . $this->table . " AS t ";

		if (!is_null($this->_join)){
			$query .= ' ' . implode(' ', $this->_getJoins()) . ' ';
		}

		if (!empty($this->_where)){
			$query .= " WHERE " . implode(' AND ', $this->_where);
		}

		if (!empty($this->_group)){
			$query .= " GROUP BY " . implode(', ', $this->_group);
		}

		if (!empty($this->_order)){
			$query .= " ORDER BY " . implode(', ', $this->_order);
		}

		if (!empty($this->_limit)){
			$query .= " LIMIT " . $this->_limit;
		}

		$rs = mysqli_query($this->conn, $query);

		if (mysqli_num_rows($rs) > 1) {
			throw new \Exception("Multiple rows selected. Please verify.", 1);
		}

		$this->_checkError();

		$this->_cleanupAttributes();

		return mysqli_fetch_array($rs)[0];
	}

    /**
     * Gets record by PK(Primary Key).
     *
	 * Example: __$this->db->getByPK();__
     * 
     * @param string $pkValue Value used for table PK.
     *
     * @return string The value from the column/row.
    */
	public final function getByPK($pkValue) {

		$primaryKey = $this->getPKColumn();

		$query = "
			SELECT *
			FROM " . $this->table . "
			WHERE " . $primaryKey . " = '" . $this->sanitize($pkValue) . "'
		";

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$this->_cleanupAttributes();

		return mysqli_fetch_object($rs);
	}

    /**
     * Insert a new record based on data specified.
     *
     * Example:
     *
	 *		$this->db->model->name = 'John';
	 *		$this->db->model->email = 'john@email.com';
	 *		$this->db->model->birthday = '1980-02-04';
	 *		$this->db->insert();
     * 
     * @return bool Whether the insert was successfull or not.
    */
	public final function insert() {

		$columnsFullDetails = $this->getTableColumns($this->table, true);

		$data = array_fill_keys(array_keys($columnsFullDetails), '');

		foreach ($data as $column => $value){

			if (!isset($columnsFullDetails[$column]['auto_increment'])){
				$data[$column] = (isset($this->model->$column)) ? "'" . $this->sanitize($this->model->$column) . "'" : ((isset($columnsFullDetails[$column]['default'])) ? "'" . $columnsFullDetails[$column]['default'] . "'" : "''");
			} else {
				unset($data[$column]); // remove from this the keys with autoincrement
			}
		}

		$query = "
			INSERT INTO " . $this->table . "
			(" . implode(', ', array_keys($data)) . ")
			VALUES
			(" . implode(', ', array_values($data)) . ")
		";

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		return $rs;
	}

    /**
     * Update a set of records based on specified filters.
     * 
     * Example:
     *
	 *		$this->db->model->name = 'John';
	 *		$this->db->model->email = 'john@email.com';
	 *		$this->db->where('id=2');
	 *		$this->db->model->birhtday = '1980-02-04';
	 *		$this->db->update();
	 *
     * @throws \Exception Disable safe_changes before running UPDATE without WHERE.
     *
     * @return bool The number of affected rows.
    */
	public final function update() {

		if (Config::get('db.safe_changes') && empty($this->_where)) {
			throw new \Exception("Disable safe_changes before running UPDATE without WHERE.", 1);
		}

		$data = array_fill_keys($this->getTableColumns($this->table), '');

		$update = [];

		foreach ($data as $column => $value){

			if (isset($this->model->$column)){
				$update[] = $column . " = '" . $this->sanitize($this->model->$column) . "'";
			}
		}

		$query = "
			UPDATE " . $this->table . "
			SET " . implode(', ', $update) . "
			WHERE " . implode(' AND ', $this->_where) . "
		";

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$this->_cleanupAttributes();

		return mysqli_affected_rows($this->conn);
	}

    /**
     * Delete a set of records based on specified filters.
     * 
     * Example:
     *
     *		$this->db->where('id=2');
	 *		$this->db->delete();
     *
     * @throws \Exception Disable safe_changes before running DELETE without WHERE.
     *
     * @return bool Whether the delete was successfull or not.
    */
	public final function delete() {

		if (Config::get('db.safe_changes') && empty($this->_where)) {
			throw new \Exception("Disable safe_changes before running DELETE without WHERE.", 1);
		}

		$query = "
			DELETE FROM " . $this->table . "
			WHERE " . $this->sanitize(implode(' AND ', $this->_where)) . "
		";

		$this->_cleanupAttributes();

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		return $rs;
	}

	/**
	 * Get Columns of a specifiec Table. If the Table argument is ommited it will use the current Table.
	 *
	 * Example: __$this->db->getTableColumns($MyTable);__
	 *
	 * @param string $table The table name for which you want to get Columns.
	 * @param boolean $asKey Whether or not return the result as key.
	 *
	 * @return array The columns of the Table.
	*/
	public final function getTableColumns($table = null, $asKey = false) {

		if (is_null($table)) {
			$table = $this->table;
		}

		$query = "
			DESCRIBE " . $table . "
		";

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$result = array();

		while ($row = mysqli_fetch_assoc($rs)) {

			if ($asKey) {

				$type = null;

				switch ($row['Type']){
					case 'datetime':
						$type = $row['Type'];
					break;
				}

				$dataTypes = array('int', 'tinyint', 'varchar');

				foreach ($dataTypes as $dataType) {
					if (strpos($row['Type'], $dataType . '(') !== false){
						$type = $dataType;
					}
				}

				$result[$row['Field']] = array();

				if (!is_null($type)) { 
					$result[$row['Field']]['type'] = $type;
				}
				
				if (!is_null($row['Key'])) { 
					$result[$row['Field']]['key_type'] = $row['Key'];
				}

				if (!is_null($row['Extra']) && $row['Extra'] == 'auto_increment') { 
					$result[$row['Field']]['auto_increment'] = true;
				}

				if (!is_null($row['Default'])) { 
					$result[$row['Field']]['default'] = $row['Default'];
				}

			} else {
				$result[] = $row['Field'];
			}
		}

		return $result;
	}

	/**
	 * Sanitize a string before being sent to DB Server to avoid SQL Injections or query syntax errors.
	 *
	 * Example: __$this->db->sanitize();__
	 *
	 * @param string $string The required string, tipically a value.
	 *
	 * @return string Contains sanitized string. Executes first a stripslashes to avoid adding multiple slashes in case the user applies the method multiple times.
	*/
	public function sanitize($string){

		if (is_array($string) || is_object($string)){
			print_r($string);
			die('You tried to sanitize a non string');
		}

		return addslashes(stripslashes($string));
	}

	/**
	 * Table truncate.
	 *
	 * Example: __$this->db->truncate();__
	 *
	 * @todo Change die method with \Exception.
	 *
	 * @return null In case of not being set $this->table it will die with an error message.
	*/
	public final function truncate() 
	{
		if (!$this->table) {
			die('Before using Active Records please set the \'TABLE\' constant on your model linked to specific table');
		}

		$query = 'TRUNCATE TABLE '. $this->table;

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();
	}

	/**
	 * Get PK(Primary Key) Column.
	 *
	 * Example: __$this->db->getPKColumn();__
	 *
	 * @return string|null Table column. If no match as PK in the table it will return NULL.
	*/
	public final function getPKColumn(){

		$columns = $this->getTableColumns($this->table, true);

		foreach ($columns as $column => $data){
			if ($data['key_type'] == 'PRI'){
				return $column;
			}
		}

		return null;
	}

	/**
	 * Count the results for active table.
	 *
	 * Example: __$this->db->count();
	 *
	 * @return int The number of rows ecountered.
	*/
	public final function count() {

		$query = "
			SELECT COUNT(*) AS cnt
			FROM " . $this->table . "
		";

		if (!empty($this->_where)){
			$query .= ' WHERE ' . implode(' AND ', $this->_where);
		}

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$row = mysqli_fetch_assoc($rs);

		$this->_cleanupAttributes();

		return (int)$row['cnt'];
	}

	/**
	 * Get the max record found.
	 *
	 * Example: __$this->db->max();__
	 *
	 * @param string $field The field for which max function will be applied.
	 * @param bool $cleanupAttributes In case you want to run a single MAX function and not to reset data use this as FALSE, otherwise as TRUE or ommit it.
	 * @throws \Exception You must specify the field.
	 *
	 * @return int The maximum number ecountered.
	*/
	public final function max($field = null, $cleanupAttributes = true) {

		if (is_null($field)) {
			throw new \Exception("You must specify the field.", 1);
		}

		$query = "
			SELECT MAX(" . $field . ") AS max
			FROM " . $this->table . "
		";

		if (!empty($this->_where)){
			$query .= ' WHERE ' . implode(' AND ', $this->_where);
		}

		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$row = mysqli_fetch_assoc($rs);

		if ($cleanupAttributes) {
			$this->_cleanupAttributes();
		}

		return (int)$row['max'];
	}

	/**
	 * Get the the next incremental ID found.
	 *
	 * Example: __$this->db->increment();__
	 *
	 * @param string $field the field for which increment will be calculated
	 * @throws \Exception You must specify the field.
	 * @throws \Exception Cannot get increment for non integer fields.
	 *
	 * @return int The next incremental number available. If the table is empty 1 will be returned.
	*/
	public final function increment($field = null) {

		if (is_null($field)) {
			throw new \Exception("You must specify the field.", 1);
		}

		$max = $this->max($field, false);

		if ($max != (int)$max || strlen($max) != strlen((int)$max)){
			throw new \Exception("Cannot get increment for non integer fields.", 1);
		}

		return $this->max($field, false) + 1;
	}

	/**
	 * Gets the last inserted ID.
	 *
	 * Example: __$this->db->insertId();__
	 *
	 * @return int The last inserted ID.
	*/
	public function insertId() {
		return mysqli_insert_id($this->conn);
	}

	/**
	 * Directly executes a query. It may be used for special, complex or big queries.
	 *
	 * Example: __$this->db->execute();__
	 *
	 * @param string $query The required query to execute.
	 *
	 * @return resource The query result set.
	*/
	public final function execute($query){
		
		$rs = mysqli_query($this->conn, $query);

		$this->_checkError();

		$this->_cleanupAttributes();

		return $rs;
	}

	/**
	 * Directly executes a multi query. It may be used for special, complex or big queries but also for multiqueries.
	 *
	 * Example: __$this->db->executeMulti();__
	 *
	 * @param string $query The required query to execute.
	 * @todo You need to parse multi result in case you want to use this method. For SELECT it is not implemented.
	 *
	 * @return resource The query result set.
	*/
	public final function executeMulti($query){

		$rs = mysqli_multi_query($this->conn, $query);

		$this->_checkError();

		$this->_cleanupAttributes();

		return $rs;
	}

	/**
	 * Begins a transaction.
	 *
	 * Example: __$this->db->beginTransaction();__
	 *
	 * @param string $type - Trasaction type.
	 *
	 * @return bool TRUE if transaction set is OK, FALSE otherwise.
	*/
	public final function beginTransaction($type)
	{
		if (function_exists('mysqli_begin_transaction')){
			$rs = mysqli_begin_transaction($this->conn, $type);
		} else {
			$rs = mysqli_autocommit($this->conn, FALSE);
		}

		return $rs;
	}

	/**
	 * Commit a transaction.
	 *
	 * Example: __$this->db->commitTransaction();__
	 *
	 * @return bool TRUE if transaction commit is OK, FALSE otherwise.
	*/
	public final function commitTransaction()
	{
		$rs = mysqli_commit($this->conn);
		
		return $rs;
	}

	/**
	 * Rollback a transaction.
	 *
	 * Example: __$this->db->rollbackTransaction();__
	 *
	 * @return bool TRUE if transaction rollback is OK, FALSE otherwise.
	*/
	public final function rollbackTransaction()
	{
		$rs = mysqli_rollback($this->conn);

		return $rs;
	}

	/**
	 * Check whether a table exist or not.
	 *
	 * @param string $database The database where to check for the given table.
	 * @param string $table The Table that you want to check.
	 *
	 * @return bool TRUE if exists, FALSE otherwise.
	*/
	public final function tableExist($database, $table)
	{
		if (in_array($table, $this->showTables($database))) {
			return true;
		}

		return false;
	}

	/**
	 * Get list of the existig databases.
	 *
	 * Example: __$this->db->showDatabases();__
	 *
	 * @return array - Databases list
	*/
	public final function showDatabases()
	{
		$result = [];

		$rs = mysqli_query($this->conn, 'SHOW DATABASES');

		while ($row = mysqli_fetch_assoc($rs)) {
			$result[] = $row['Database'];
		}
		
		return $result;
	}

	/**
	 * Get list of existig tables from a specified database.
	 *
	 * Example: __$this->db->showTables(DB_NAME);__
	 *
	 * @param string $database The Database from where will get the tables names.
	 *
	 * @return array - Tables list.
	*/
	public final function showTables($database)
	{
		$result = [];

		$rs = mysqli_query($this->conn, "SELECT TABLE_NAME FROM information_schema.tables WHERE TABLE_SCHEMA = '".$this->sanitize($database)."'");

		while ($row = mysqli_fetch_assoc($rs)) {
			$result[] = $row['TABLE_NAME'];
		}

		return $result;
	}

	/**
	 * It is used to clear the filters of the query in order to prepare for the next one.
	 *
	 * @return null
	*/
	private final function _cleanupAttributes() {
		$this->_columns = [];
		$this->_where = [];
		$this->_group = [];
		$this->_order = [];
		$this->_limit = '';
		$this->_join = null;
		$this->_columns = [];
	}

	/**
	 * Check if there are any errors catched from DB Server. If encoutered it will track them.
	 *
	 * @throws \Exception The DB Server Error encountered.
	 *
	 * @return null It halts the application execution.
	*/
	private final function _checkError(){

		$result = mysqli_error($this->conn);

		if (!empty($result)){

			$backTrace = debug_backtrace();

			$errorResult = [
				'Message' 		=> $result,
				'Type' 			=> 'MySql Error',
				'File' 			=> $backTrace[1]['file'],
				'Line' 			=> $backTrace[1]['line'],
				'Function' 		=> $backTrace[1]['function'],
				'Last query' 	=> print_r($backTrace[1]['args'], true),
			];

			foreach ($errorResult as $key => $value) {
				$errorFileResult[] = print_r($value, true);
			}

			throw new \Exception(implode(PHP_EOL, $errorFileResult), 1);
			
			// trigger_error ( implode(PHP_EOL, $errorFileResult), E_USER_ERROR );

			die;
		}
	}

	/**
	 * Prepares the joins based on relations specified.
	 *
	 * @todo Replace die with an \Exception.
	 *
	 * @return array The resulting SQL joins.
	*/
	private final function _getJoins() {

		$joins = '';

		if (!is_null($this->_join)){

			$joins = [];

			foreach ($this->_join as $join){

				if (!isset($this->relations[$join])){
					die('<strong>' . $join . '</strong> relation is not defined.');
				}

				$joins[] = (isset($this->relations[$join]['join']) ? strtoupper($this->relations[$join]['join']) : 'LEFT') . ' JOIN ' . $this->relations[$join]['table'] . ' ON ' . $this->relations[$join]['on'];
			}
		}

		return $joins;
	}
}