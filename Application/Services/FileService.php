<?php

/**
 * File Service Makes operations with files or on files
 *
 * @author Iulian Cristea
 * @copyright 2015-2016 memobit.ro
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @package Application\Services
 * @version 1.0.1
*/

namespace Application\Services;

/**
 * File Service Class Makes operations with files or on files
 * 
*/
class FileService {

	/**
	 * Move files. This verifies of the files during this operation.
	 *
	 * @param string $source The source file that you want to move.
	 * @param string $destination The destination file where do you want to move.
	 * @param bool $overwriteDestination Wheather to overwrite or halt the operation if the file already exist.
	 * @throws \Exception Source cannot be empty.
	 * @throws \Exception Destination cannot be empty.
	 * @return string|bool Returns the error if the operation cannot be performed and true/false if the file has been moved.
	*/
	public static function moveFile($source, $destination, $overwriteDestination = false) {

		if (empty($source)) {
			throw new \Exception("Source cannot be empty", 1);
		}

		if (empty($destination)) {
			throw new \Exception("Destination cannot be empty", 1);
		}

		if (file_exists($destination)) {
			if ($overwriteDestination) {
				unlink($destination);
			} else {
				return 'Destination file already exists.';
			}
		}

		if (!file_exists($source)) {
			return 'Source file does not exists.';
		}

		return rename($source, $destination);
	}

	/**
	 * Deletes a file.
	 *
	 * @param string $filename The full path filename that you want to delete.
	 * @return string|bool An error string if the filename variable is emtpy or TRUE/FALSE if the file has been or hasn't been deleted.
	*/
	public static function deleteFile($filename) {

		if (empty($filename)) {
			return 'Filename cannot be empty.';
		}

		if (file_exists($filename)) {
			return unlink($filename);
		}
	}

	/**
	 * Gets the extension of a given filename or entire path with the filename.
	 *
	 * @param string $filename The file from which you want to extract the extension
	 * @return string If the filename is empty returns a error otherwise will return the extension of that file.
	*/
	public static function getExtension($filename) {
		
		if (empty($filename)) {
			return 'Filename cannot be empty.';
		}

		return substr($filename, strrpos($filename, '.'));
	}
}