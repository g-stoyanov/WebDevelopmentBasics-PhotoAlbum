<?php

namespace Controllers;

class Login_Controller extends Master_Controller {

    public function __construct() {
        parent::__construct(get_class(),
            $models = array(
                'master' => 'master'
            ),
            '/views/login/');
    }

    public function index() {

        if( ! empty( $_POST['username'] ) && ! empty( $_POST['password'] ) ) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $auth = \Lib\Auth::get_instance();
            $is_logged_in = $auth->login( $username, $password );

            var_dump($is_logged_in);
        }

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }
}