<?php

/**
 * Log User Activity Model.
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Models
 * @version 1.0.1
*/

namespace Application\Models;

use Core\DBModel;

/**
 * Log User Activity Model Class.
 * 
*/
class LogModel extends DBModel {

	/**
	 * @var string $table The working table name.
	*/
	protected $table = 'logs';

	/**
	 * @var array $relations The join relations used for current Model.
	*/
	public $relations = [
		'logs__users' => [
				'table' => 'users AS u',
				'on'	=> 't.user_id = u.id',
			],
	];

	/**
	 * Get all records.
	 * 
	 * @param int $limit The limit of records you want to get.
	 * @param string $filter The WHERE filter you want to apply. Can be ommited.
	 *
	 * @return array The data result of the query.
	*/
	public function getAll($limit, $filter = null) {

		$this->db->columns('t.id, name, action, details, date_added');
		$this->db->join('logs__users');
		$this->db->where('date_added > DATE_SUB(NOW(), INTERVAL 3 MONTH)');

		if (!is_null($filter) && isset($filter['Logs'])) {
			foreach ($filter['Logs'] as $key => $value) {
				$this->db->where($key . " LIKE '%" . $value . "%'");
			}
		}

		$this->db->order('date_added DESC');

		$this->db->limit($limit);
		
		return $this->db->getRows();
	}

	/**
	 * Inserts data into working table.
	 * 
	 * @param array $data The data you want to insert into the working table.
	 *
	 * @return null
	*/
	public function insert($data) {

		foreach ($data as $key => $value) {
			$this->db->model->$key = $value;
		}

		$this->db->model->date_added = date('Y-m-d H:i:s');
		
		$this->db->insert();
	}

	/**
	 * Delete data from working table based on specified PK ID.
	 * 
	 * @param int $id The PK ID that you want to delete.
	 *
	 * @return null
	*/
	public function delete($id) {

		$this->db->where('id = ' . $id);
		
		return $this->db->delete();
	}
}