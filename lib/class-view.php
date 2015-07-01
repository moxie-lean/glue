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

	/**
	 * Static method to create the View object
	 *
	 * @param   String  $filename	Path to the file
	 * @return  View    $view		Return the current object (View);
	 */
	public static function make( $filename = '' ) {
		$view = new View( $filename );
		// Process the file
		$view->file_handle->process();
		return $view;
	}
}

