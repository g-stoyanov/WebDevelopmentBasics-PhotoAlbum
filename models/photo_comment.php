<?php
namespace Models;

class Photo_comment_Model extends Master_Model {

    public function __construct( $args = array() ){
        parent::__construct( array( 'table' => 'photo_comments' ) );
    }
}