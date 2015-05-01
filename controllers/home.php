<?php

namespace Controllers;

class Home_Controller extends Master_Controller {

    public function __construct() {
        parent::__construct(get_class(),
            $models = array(
                'album' => 'album',
                'album_vote' => 'album_vote'
            ),
            '/views/home/');
    }

    public function index() {
        $albums = $this->models['album']->find(array('order' => 'id'));

        $columns = 'SUM(vote)';

        for($i = 0; $i < count($albums); $i++) {
            $album_votes = $this->models['album_vote']->find(array(
                'where' => 'album_id = ' . $albums[$i]['id'], 'columns' => $columns
            ));



            $votes = array('votes' => $album_votes[0][$columns] ? $album_votes[0][$columns] : 0);
            $albums[$i] = array_merge( $albums[$i], $votes );
        }

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }

    public function login() {

        if( count($this->logged_user) > 0 ){
            header('Location: /' . DX_ROOT_PATH . 'user/home/index');
            die;
        } else {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $auth = \Lib\Auth::get_instance();

                $is_logged_in = $auth->login($username, $password);

                if ($is_logged_in) {
                    header('Location: /' . DX_ROOT_PATH . 'user/home/index');
                    die;
                }
            }

            $template_name = DX_ROOT_DIR . $this->views_dir . 'login.php';

            include_once $this->layout;
        }
    }

    public function register() {

        if( count($this->logged_user) > 0 ){
            header('Location: /' . DX_ROOT_PATH . 'user/home/index');
            die;
        } else {

            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $auth = \Lib\Auth::get_instance();
                $is_logged_in = $auth->register($username, $password);

                if ($is_logged_in) {
                    header('Location: /' . DX_ROOT_PATH . 'user/home/index');
                    die;
                }
            }

            $template_name = DX_ROOT_DIR . $this->views_dir . 'register.php';

            include_once $this->layout;
        }
    }

    public function logout() {

        $auth = \Lib\Auth::get_instance();

            if($auth->logout()){
                header('Location: /' . DX_ROOT_PATH . 'home/index');
                die;
            }
    }
}