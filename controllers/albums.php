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
}