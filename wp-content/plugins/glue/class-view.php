<?php namespace glue;

class View {
  private $data;
  private $file_handle;

  public function __construct( $filename = '' ) {
    $this->data = array();
    $this->file_handle = new FileHandle( $filename );
  }

  public static function make( $filename = '' ) {
    $view = new View( $filename );
    // Process the file
    $view->file_handle->process();
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

  public function __get( $key = '' ){
    if ( $key && array_key_exists( $key, $this->data ) ) {
      return $this->data[ $key ];
    }
  }

  public function render(){
    extract( $this->data );
    include $this->file_handle->get_fullpath();
  }

  public function exist( $variable ){
    var_dump( isset( $variable ) );
  }
}

