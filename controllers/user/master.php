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
            header('Location: /' . DX_ROOT_PATH . 'home/index');
            die;
        }

        $this->layout = DX_ROOT_DIR . '/views/layouts/user.php';
    }

    public function index() {

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }
}