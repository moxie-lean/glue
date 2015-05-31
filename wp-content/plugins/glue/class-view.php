<?php namespace glue;

class View {
  private $file;
  private $data;
  protected $base_path;

  public function __construct( $filename = '' ) {
    $this->data = array();
    $this->file = $filename;
    $this->process_file();
    $this->base_path = get_template_directory();
  }

  public function process_file() {
    $this->review_extension();
  }

  public function review_extension() {
    if( $this->file && ! $this->is_php() ) {
      $this->file = $this->file . '.php';
    }
  }

  public function is_php() {
    return '.php' === substr( $this->file, -4, 4);
  }

  public static function make( $filename = '' ) {
    $view = new View( $filename );
    return $view;
  }

  public function set( $key = '', $value = '' ) {
    $this->with( $key, $value );
  }

  public function with( $key = '', $value = '' ) {
    if ( $key ) {
      $this->data[$key] = $value;
    }
    return $this;
  }

  public function __get( $key ){
    var_dump( $key );
  }

  public function render(){
    if( file_exists( $this->base_path . '/' . 'views/' . $this->file ) ) {
      extract( $this->data );
      include( $this->base_path . '/' . 'views/' . $this->file );
    }
  }

  public function exist( $variable ){
    var_dump( isset( $variable ) );
  }
}

