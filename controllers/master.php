<?php

namespace Controllers;

class Master_Controller
{

    protected $layout;
    protected $views_dir;
    protected $class_name;
    protected $models;

    public function __construct($class_name = '\Controllers\Master_Controller',
                                $models = array(
                                    'master' => 'master'
                                ),
                                $views_dir = '/views/master/')
    {

        $this->views_dir = $views_dir;
        $this->class_name = $class_name;


        foreach ($models as $key => $value) {
            include_once DX_ROOT_DIR . "models/{$value}.php";

            $model_class = "Models\\" . ucfirst($value) . "_Model";

            $this->models[$key] = new $model_class(array('table' => 'none'));
        }


        $auth = \Lib\Auth::get_instance();
        $logged_user = $auth->get_logged_user();
        $this->logged_user = $logged_user;

        $this->layout = DX_ROOT_DIR . '/views/layouts/default.php';
    }

    public function index()
    {

        $template_name = DX_ROOT_DIR . $this->views_dir . 'view.php';

        include_once $this->layout;
    }
}