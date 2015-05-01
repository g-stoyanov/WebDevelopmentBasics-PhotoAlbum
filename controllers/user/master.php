<?php

namespace User\Controllers;

class User_Controller extends \Controllers\Master_Controller {

    public function __construct($class_name = '\User\Controllers\User_Controller',
                                $models = array(
                                    'master' => 'master'
                                ),
                                $views_dir = 'views/user/master/') {
        parent::__construct( $class_name, $models, $views_dir);

        $auth = \Lib\Auth::get_instance();
        $logged_user = $auth->get_logged_user();

        if( empty( $logged_user ) ) {
            die( 'No access allowed here!' );
        }
    }

    public function index() {

        $template_name = DX_ROOT_DIR . $this->views_dir . 'view.php';

        include_once $this->layout;
    }
}