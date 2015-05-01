<?php
namespace Models;

class Category_vote_Model extends Master_Model {

    public function __construct( $args = array() ){
        parent::__construct( array( 'table' => 'category_votes' ) );
    }
}