<?php

namespace Controllers;

class Albums_Controller extends Master_Controller {

    protected $layout;
    protected $views_dir;

    public function __construct() {
        parent::__construct(get_class(),
                            'album',
                            '/views/albums/');
    }

    public function index() {
        $albums = $this->model->find();
        var_dump($albums); die();
        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';
    }
}