<?php

namespace Models;

class Album_Model extends Master_Model {

    public function __construct( $args = array() ){
        parent::__construct( array( 'table' => 'albums' ) );
    }

    public function get_top_albums(){


        $query = "SELECT a.id, a.name, a.category_id, SUM(av.vote) FROM albums AS a, album_votes AS av WHERE av.album_id = a.id GROUP BY a.id ORDER BY SUM(av.vote) DESC, a.id DESC LIMIT 5";




        $result_set = $this->db->query( $query );

        $results = $this->process_results( $result_set );

        return $results;
    }
}