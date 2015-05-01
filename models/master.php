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

    public function add( $element ) {
        $keys = array_keys( $element );
        $values = array();

        foreach( $element as $key => $value ) {
            $values[] = "'" . $this->db->real_escape_string( $value ) . "'";
        }

        $keys = implode( $keys, ',' );
        $values = implode( $values, ',' );

        $query = "INSERT INTO {$this->table}($keys) VALUES ($values)";

        $this->db->query( $query );

        return $this->db->affected_rows;
    }

    public function update( $element, $update_rules = array() ) {
        $keys = array_keys( $element );

        $query = "UPDATE {$this->table} SET ";

        foreach ($element as $key => $value) {
            $have_rule = false;

            foreach ($update_rules as $rule) {
                if ($key == $rule) {
                    $have_rule = true;
                }
            }

            if($have_rule){
                continue;
            }

            $query .= "$key = '" . $this->db->real_escape_string($value) . "',";
        }

        $query = rtrim($query, ',');

        if(count($update_rules) > 0){
            $query .= " WHERE ";
            foreach ($update_rules as $rule) {
                $query .= " $rule = '" . $this->db->real_escape_string($element[$rule]) . "' AND ";
            }

            $query = rtrim($query, 'AND ');
        } else {
            $query .= "WHERE id = {$element['id']}";
        }

        var_dump($query);

        $this->db->query( $query );

        return $this->db->affected_rows;
    }

    public function find( $args = array() ){
        $defaults = array(
            'table' => $this->table,
            'limit' => $this->limit,
            'page' => $this->page,
            'where' => '',
            'columns' => '*',
            'order' => ''
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

        if(! empty( $order )){
            $query .= " ORDER BY " . $order;
        }


        $result_set = $this->db->query( $query );

        $results = $this->process_results( $result_set );

        return $results;
    }

    public function get_by_id( $id ){

        $result = $this->find( array( 'where' => 'id = ' . $id ) );

        if(count($result) > 0) {
            return $result[0];
        }

        return null;
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