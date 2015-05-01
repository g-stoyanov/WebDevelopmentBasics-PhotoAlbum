<?php
namespace Models;

class Album_vote_Model extends Master_Model {

    public function __construct( $args = array() ){
        parent::__construct( array( 'table' => 'album_votes' ) );
    }
}