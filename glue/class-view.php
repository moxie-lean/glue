<?php namespace glue;

/**
 * Class to generate the view
 */
class View {
	// Array with the data to pass to the view
	private $data;
	// Variable to hold the instance of the FileHandle object
	private $file_handle;

	/**
	 * Constructor of the object and FileHandle.
	 *
	 * @param   String  Path to the file
	 */
	public function __construct( $filename = '' ) {
		$this->data = array();
		$this->file_handle = new FileHandle( $filename );
	}

	/**
	 * Static method to create the View object
	 *
	 * @param   String    Path to the file
	 * @return  View      Return the current object (View);
	 */
	public static function make( $filename = '' ) {
		$view = new View( $filename );
		// Process the file
		$view->file_handle->process();
		return $view;
	}

	/**
	 * Another sintax to pass variables to the view. Refer to the next with method.
	 *
	 * @param   String    $key    They key to set.
	 * @param   mixed     $value  The value to store in $key.
	 */
	public function set( $key = '', $value = '' ) {
		$this->with( $key, $value );
	}

	/**
	 * Method to store data and pass it to the PHP view where the data is displayed.
	 *
	 * @param   String    $key    They key to set.
	 * @param   mixed     $value  The value to store in $key.
	 */
	public function with( $key = '', $value = '' ) {
		if ( $key ) {
			$this->data[$key] = $value;
		}
		return $this;
	}

	/**
	 * Magic method to allows user retrive the data with the sintax $this->data like:
	 * $view->title, outpus the $title withoth using echo;
	 *
	 */
	public function __get( $key = '' ){
		if ( $this->exist( $key ) ) {
			echo $this->data[ $key ];
		}
	}

	public function get( $key = '' ) {
		if( $this->exist( $key ) ) {
			return $this->data[ $key ];
		} else {
			return false;
		}
	}

	/**
	 * Test if $key exist in the array of data
	 *
	 * @param   String    string name of the key to be tested
	 * @return  boolean   True if the $data array has the $key.
	 */
	private function exist( $key = '' ) {
		return $key && is_string( $key ) && array_key_exists( $key, $this->data );
	}

	/**
	 * Render the view and creates a list of variables based on the values pased
	 * to the view with the methods set and with, also creates a $view variable to
	 * better readability instead of $this, after that loads the file.
	 */
	public function render(){
		extract( $this->data );
		$view = $this;
		include $this->file_handle->get_fullpath();
	}

	/**
	 * Check if $variable exist and if has content
	 *
	 * @param   mixed     Variable to test, can be a string, array or boolean
	 * @return  boolean   Return true if $variable exist and it's not false,
	 *                    empty string, empty array, or zero.
	 */
	public function has( $variable = '' ){
		return isset( $variable ) && $variable;
	}
}

