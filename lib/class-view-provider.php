<?php namespace glue;

class ViewProvider  extends ViewUtil{
	// Array with the data to pass to the view
	protected $data;
	// Variable to hold the instance of the FileHandle object
	protected $file_handle;

	/**
	 * Render the view and creates a list of variables based on the values pased
	 * to the view with the methods set and with, also creates a $view variable to
	 * better readability instead of $this, after that loads the file.
	 */
	public function render(){
		if ( $this->file_handle->exists() ) {
			extract( $this->data );
			$view = $this;
			include $this->file_handle->get_fullpath();
		}
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
	 * @param	Array	$collection		They key to set.
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
	 * magic method to allows user retrive the data with the sintax $this->data like:
	 * $view->title, outpus the $title withoth using echo;
	 *
	 * @param	string	$key	key to retrieve from the data array.
	 * @return	none			outputs directly the data using echo.
	 */
	public function __get( $key = '' ){
		if ( $this->exist( $key ) ) {
			echo $this->data[ $key ];
		}
	}

	/**
	 * @param	string	$key		they key to search in the data array.
	 * @return	mixed	$result		return the data of the data using the key or
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
	 * test if $key exist in the array of data
	 *
	 * @param   string    string name of the key to be tested
	 * @return  boolean   true if the $data array has the $key.
	 */
	private function exist( $key = '' ) {
		return $key && is_string( $key ) && array_key_exists( $key, $this->data );
	}
}

