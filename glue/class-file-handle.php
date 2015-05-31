<?php namespace glue;

/**
 * Class to handle the File, file extension and thing related to the file to
 * load.
 */
class FileHandle {
  // Name of the File
  private $filename;
  // Complete path to the File
  private $path;
  // Base Path, the path to the current theme
  private $base_path;

  public function __construct( $filename = '' ){
    $this->filename = $filename;
    $this->base_path = get_template_directory();
  }

  /**
   * Process the file name to check extension and set the path.
   */
  public function process() {
    $this->review_extension();
    $this->set_path();
  }

  /**
   * Check if the file has the .php extension if not added
   */
  private function review_extension() {
    if( '' !== $this->filename && ! $this->is_php() ) {
      $this->filename = $this->filename . '.php';
    }
  }

  /**
   * Test if the filename string has the extension of .php
   */
  private function is_php() {
    return '.php' === substr( $this->filename, -4, 4);
  }

  /**
   * Set the correct path to the $path variable
   */
  private function set_path() {
    $this->review_path( $this->base_path . '/views/' . $this->filename );
    $this->review_path( $this->base_path . '/' . $this->filename );
  }

  /**
   * Review if the $path variable exists if so then set that value to $this->path;
   *
   * @param   String  $path   The path to review
   */
  private function review_path( $path = '' ) {
    if ( ! $this->path && file_exists( $path ) ) {
      $this->path = $path;
    }
  }

  /**
   * Getter of the path variable
   *
   * @return  String $path  The fullpath to the file
   */
  public function get_fullpath(){
    return $this->path;
  }
}
