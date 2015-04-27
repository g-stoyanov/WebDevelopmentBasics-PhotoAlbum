<?php

namespace User\Controllers;

class Albums_Controller extends User_Controller {

    protected $layout;
    protected $views_dir;

    public function __construct() {
        parent::__construct(get_class(),
            $models = array(
                'album' => 'album',
                'category' => 'category'
            ),
            'views/user/albums/');
    }

    public function index() {
        $albums = $this->models['album']->find();

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }

    public function add() {
        var_dump($_POST);
        if( ! empty ( $_POST['name'] ) &&  ! empty ( $_POST['category_id'] ) ) {
            $name = $_POST['name'];
            $category_id = $_POST['category_id'];
            $user_id = $_POST['user_id'];

            $new_album = array(
                'name' => $name,
                'category_id' => $category_id,
                'user_id' => $user_id
            );

            $this->models['album']->add($new_album);
        }

        $categories = $this->models['category']->find();


        $template_name = DX_ROOT_DIR . $this->views_dir . 'add.php';

        include_once $this->layout;
    }
}