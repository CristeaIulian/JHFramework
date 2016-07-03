<?php

/**
 * User Model.
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
 * User Model Class.
 * 
*/
class UserModel extends DBModel {

	/**
	 * @var string $table The working table name.
	*/
	protected $table = 'users';

	/**
	 * @var array $relations The join relations used for current Model.
	*/
	public $relations = [
		'users__logs' => [
				'table' => 'logs AS l',
				'on'	=> 't.id = l.user_id',
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

		$this->db->where('deleted_at = 0');

		if (!is_null($filter) && isset($filter['Users'])) {
			foreach ($filter['Users'] as $key => $value) {
				$this->db->where($key . " LIKE '%" . $value . "%'");
			}
		}

		$this->db->limit($limit);
		return $this->db->getRows();
	}

	/**
	 * Get User Details by his Email.
	 * 
	 * @param string $email The Email of the User.
	 *
	 * @return object The User Details.
	*/
	public function getUserByEmail($email) {

		$this->db->where("email='" . $email . "' AND deleted_at = 0");
		return $this->db->getRow();
	}

	/**
	 * Get User Details by a generated Code.
	 * 
	 * @param string $code The Code generated for the User.
	 *
	 * @return object User Details.
	*/
	public function getUserByCode($code) {

		$this->db->where("code='" . $code . "' AND deleted_at = 0");
		return $this->db->getRow();
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
		
		return $this->db->insert();
	}

	/**
	 * Update using your data into working table for a specific PK ID.
	 * 
	 * @param array $data The data you want to update into the working table.
	 * @param int $id The ID for which will apply the change.
	 *
	 * @return null
	*/
	public function update($data, $id) {

		foreach ($data as $key => $value) {
			$this->db->model->$key = $value;
		}

		$this->db->where('id = ' . $id);
		
		return $this->db->update();
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