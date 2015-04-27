<?php

define( 'DX_ROOT_DIR', dirname(__FILE__) . '/' );
define( 'DX_ROOT_PATH', basename( dirname( __FILE__ ) ) . '/' );

$request = $_SERVER['REQUEST_URI'];
$request_home = '/' . DX_ROOT_PATH;

$controller = 'master';
$method = 'index';
$user_routing = false;
$param = array();

include_once 'config/db.php';
include_once 'lib/database.php';
include_once 'lib/auth.php';
include_once 'controllers/master.php';
include_once 'models/master.php';

if( !empty( $request ) ){
    if( 0 === strpos( $request, $request_home ) ){
        $request = substr($request, strlen($request_home));

        if( 0 === strpos( $request, 'user/' ) ) {
            $user_routing = true;
            include_once 'controllers/user/master.php';
            $request = substr( $request, strlen( 'user/' ) );
        }

        $components = explode( '/', $request, 3 );

        if(1 < count( $components )){
            list( $controller, $method ) = $components;

            if( isset( $components[2] ) ){
                $param = $components[2];
            }

            $user_folder = $user_routing ? 'user/' : '';

            include_once 'controllers/' . $user_folder . $controller . '.php';
        }
    }
}

$user_namespace = $user_routing ? 'User' : '';

$controller_class = $user_namespace . '\Controllers\\' . ucfirst( $controller ) . '_Controller';

$instance = new $controller_class();

if( method_exists( $instance, $method ) ){
    call_user_func_array( array( $instance, $method ), array( $param ) );
}

$db_object = \Lib\Database::get_istance();

$db_conn = $db_object::get_db();