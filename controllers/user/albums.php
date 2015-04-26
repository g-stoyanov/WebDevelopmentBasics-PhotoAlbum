<?php

namespace User\Controllers;

class Albums_Controller extends User_Controller {

    protected $layout;
    protected $views_dir;

    public function __construct() {
        parent::__construct(get_class(),
            'album',
            'views/user/albums/');
    }

    public function index() {
        $albums = $this->model->find();

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }
}