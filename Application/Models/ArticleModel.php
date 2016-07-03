<?php

/**
 * Article Model.
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
 * Article Model Class.
 * 
*/
class ArticleModel extends DBModel {

	/**
	 * @var string $table The working table name.
	*/
	protected $table = 'articles';

	/**
	 * @var array $relations The join relations used for current Model.
	*/
	public $relations = [
		'articles__articles_categories' => [
				'table' => 'articles_categories AS aca',
				'on'	=> 't.category_id = aca.id',
			],
		'articles__articles_comments' => [
				'table' => 'articles_comments AS aco',
				'on'	=> 't.id = aco.article_id',
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
	public function getAll($limit = null, $filter = null) {

		$this->db->columns('t.id, category_id, aca.name AS category_name, title, t.slug, photo, description, t.date_added, views, likes, enabled, COUNT( aco.id ) AS comments_no');

		$this->db->join(['articles__articles_categories', 'articles__articles_comments']);

		if (!is_null($filter) && isset($filter['Articles'])) {
			foreach ($filter['Articles'] as $key => $value) {
				$this->db->where($key . " LIKE '%" . $value . "%'");
			}
		}

		$this->db->group('t.id');

		$this->db->order('category_name, title');

		if (!is_null($limit)) {
			$this->db->limit($limit);
		}

		return $this->db->getRows();
	}

	/**
	 * Get information for a specific field.
	 * 
	 * @param string $field The field for which you want to retrieve data.
	 * @param int $id The PK ID for which you want to get data.
	 *
	 * @return string The value of the field.
	*/
	public function getFieldData($field, $id) {
		$this->db->columns($field);

		$this->db->where('id = ' . $id);

		return $this->db->getOne();
	}

	/**
	 * Get some article details.
	 * 
	 * @param int $id The PK ID for which you want to get details.
	 *
	 * @return object Article Details.
	*/
	public function getDetails($id) {
		$this->db->columns('title, description');

		$this->db->where('id = ' . $id);

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