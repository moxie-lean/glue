<?php namespace glue;

/**
 * Class to generate the view
 */
class View extends ViewProvider{
	/**
	 * Constructor of the object and FileHandle.
	 *
	 * @param   String  $filename	Path to the file
	 */
	public function __construct( $filename = '' ) {
		$this->data = array();
		$this->file_handle = new FileHandle( $filename );
	}
}

