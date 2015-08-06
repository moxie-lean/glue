<?php namespace glue;

class ViewUtil{
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

	/**
	 * call a callback inside of an array.
	 *
	 * @param	string	$key		the name of the key in the asociative array.
	 * @param	array	$options	asociative array where the callback is stored.
	 */
	public function call_option( $key = '', $options = array() ){
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
}
