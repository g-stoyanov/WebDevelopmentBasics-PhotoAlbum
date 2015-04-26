<?php

namespace Models;

class Master_Model {

    protected $table;
    protected $limit;
    protected $page;
    protected $db;

    public function __construct( $args = array() ) {
        $defaults = array(
            'limit' => 0,
            'page' => 1
        );

        $args = array_merge( $defaults, $args );

        if( !isset( $args['table'] ) ){
            die( 'Table not defined' );
        }

        extract( $args );

        $this->table = $table;
        $this->limit = $limit;
        $this->page = $page;


        $db_object = \Lib\Database::get_istance();
        $this->db = $db_object::get_db();
    }

    public function find( $args = array() ){
        $defaults = array(
            'table' => $this->table,
            'limit' => $this->limit,
            'page' => $this->page,
            'where' => '',
            'columns' => '*',
        );

        $args = array_merge( $defaults, $args );

        extract( $args );

        $query = "SELECT {$columns} FROM {$table}";

        if( ! empty( $where ) ){
            $query .= " WHERE {$where}";
        }

        if( ! empty( $limit ) && ! empty( $page ) ){
            $skip = $limit * ($page - 1);
            $query .= " LIMIT {$skip}, {$limit}";
        }

        $result_set = $this->db->query( $query );

        $results = $this->process_results( $result_set );

        return $results;
    }

    protected function process_results( $result_set ){
        $results = array();

        if( ! empty( $result_set ) && $result_set->num_rows > 0 ){
            while( $row = $result_set->fetch_assoc() ){
                $results[] = $row;
            }
        }

        return $results;
    }
}