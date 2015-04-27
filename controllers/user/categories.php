<?php

namespace User\Controllers;

class Categories_Controller extends User_Controller {

    protected $layout;
    protected $views_dir;

    public function __construct() {
        parent::__construct(get_class(),
            'category',
            'views/user/categories/');
    }

    public function index() {
        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }
}