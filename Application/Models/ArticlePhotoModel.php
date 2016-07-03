<?php

/**
 * Article Photo Model.
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
 * Article Photo Model Class.
 * 
*/
class ArticlePhotoModel extends DBModel {

	/**
	 * @var string $table The working table name.
	*/
	protected $table = 'articles_photos';

	/**
	 * Get all records.
	 * 
	 * @param int $article_id The Article ID for which you want to extract photo information.
	 *
	 * @return array The Photo Article Data.
	*/
	public function getAll($article_id) {

		$this->db->columns('id, article_id, filename');

		$this->db->where('article_id = ' . $article_id);

		return $this->db->getRows();
	}

	/**
	 * Gets an article photo filename by PK ID.
	 * 
	 * @param int $id The ID for which you want to get the filename.
	 *
	 * @return string The filename.
	*/
	public function getFilenameById($id) {
		$this->db->columns('filename');

		$this->db->where('id = ' . $id);

		return $this->db->getOne();
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