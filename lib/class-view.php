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
	 * Public method to render a collection, as an example a collection of Views
	 *
	 * @param   Array	$collection    They key to set.
	 * @param	Array	$options		The callback options to render while the iterate over
	 *									the collection. Avilable callbaks as follows:
	 *										array(
	 *											'before_loop' => function(){}
	 *											'before_view' => function(){}
	 *											'after_view' => function(){}
	 *											'after_loop' => function(){}
	 *										);
	 */
	public function render_collection( $collection = array(), $options = array() ) {
		if ( is_array( $collection ) ) {
			$this->call_option('before_loop', $options);
			foreach( $collection as $view ) {
				$this->call_option('before_view', $options);

				if ( $view instanceof \glue\View ){
					$view->render();
				}
				$this->call_option('after_view', $options);
			}
			$this->call_option('after_loop', $options);
		}
	}

	/**
	 * Call a callback inside of an array.
	 *
	 * @param	String	$key		The name of the key in the asociative array.
	 * @param	Array	$options	Asociative array where the callback is stored.
	 */
	private function call_option( $key = '', $options = array() ){
		if ( $this->it_has_callback($key, $options) ){
			call_user_func( $options[ $key ] );
		}
	}

	/**
	 * Function to test if an asociative array has callable function in the $key
	 * position.
	 *
	 * @param	String	$key		The name of the key in the asociative array.
	 * @param	Array	$options	Asociative array where search.
	 * @return	bool				Returns true if it has the key inside of $data
	 *								and if it's callable if not return false.
	 */
	private function it_has_callback( $key = '', $data = array() ) {
		return is_array( $data ) && array_key_exists($key, $data) && is_callable( $data[$key] );
	}

	/**
	 * Magic method to allows user retrive the data with the sintax $this->data like:
	 * $view->title, outpus the $title withoth using echo;
	 *
	 * @param	string	$key	key to retrieve from the data array.
	 * @return	none			Outputs directly the data using echo.
	 */
	public function __get( $key = '' ){
		if ( $this->exist( $key ) ) {
			echo $this->data[ $key ];
		}
	}

	/**
	 * @param	string	$key		They key to search in the data array.
	 * @return	mixed	$result		Return the data of the data using the key or
	 *								false if the key does not exist.
	 */
	public function get( $key = '' ) {
		$result = false;
		if( $this->exist( $key ) ) {
			$result = $this->data[ $key ];
		}
		return $result;
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
		if ( $this->file_handle->exists() ) {
			include $this->file_handle->get_fullpath();
		}
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

	/**
	 * Test if all the variables in the array list exist and are true
	 *
	 * @param	array		$variable	The list of variables to test in
	 * @return	boolean		$result		Apply `and` condition over all the variables
	 *									return true if all the variables in the list
	 *									exist.
	 */
	public function has_all( $variables = array() ) {
		$result = true;
		foreach ( (array) $variables as $variable ){
			if ( ! $this->has( $variable) ){
				$result = false;
				break;
			}
		}
		return $result;
	}

	/**
	 * Test if any oft he variables in the array list exist and are true
	 *
	 * @param	array		$variable	The list of variables to test in
	 * @return	boolean		$result		Apply `or` condition over all the variables
	 *									return true if any the variables in the list
	 *									exist.
	 */
	public function has_any( $variables = array() ) {
		$result = false;
		foreach ( (array) $variables as $variable ){
			if ( $this->has( $variable) ){
				$result = true;
				break;
			}
		}
		return $result;
	}
}

