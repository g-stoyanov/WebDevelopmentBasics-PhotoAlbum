<?php

namespace User\Controllers;

class Albums_Controller extends User_Controller {

    protected $layout;
    protected $views_dir;

    public function __construct() {
        parent::__construct(get_class(),
            $models = array(
                'album' => 'album',
                'category' => 'category',
                'photo' => 'photo',
                'album_vote' => 'album_vote'
            ),
            'views/user/albums/');
    }




    public function index() {
        $albums = $this->models['album']->find(array('order' => 'id'));

        $columns = 'SUM(vote)';

        for($i = 0; $i < count($albums); $i++) {
            $album_votes = $this->models['album_vote']->find(array(
                'where' => 'album_id = ' . $albums[$i]['id'], 'columns' => $columns
            ));

            $album_user_vote = $this->models['album_vote']->find(array(
                'where' => 'album_id = ' . $albums[$i]['id'] . ' and user_id = ' . $this->logged_user['id'],
                'columns' => $columns
            ));


            $votes = array('votes' => $album_votes[0][$columns] ? $album_votes[0][$columns] : 0,
                           'user_vote' => $album_user_vote[0][$columns] ? $album_user_vote[0][$columns] : 0);
            $albums[$i] = array_merge( $albums[$i], $votes );
        }

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }

    public function add() {
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
            header('Location: /'. DX_ROOT_PATH .'user/albums/index');
            die;
        }

        $categories = $this->models['category']->find(array('order' => 'id'));

        $template_name = DX_ROOT_DIR . $this->views_dir . 'add.php';

        include_once $this->layout;
    }

    public function photos( $id ) {
        $photos = $this->models['photo']->find(array(
            'where' => 'album_id = ' . $id,
            'order' => 'id'
        ));

        $template_name = DX_ROOT_DIR . $this->views_dir . 'photos.php';

        include_once $this->layout;
    }

    public function vote( $args ) {
        $path = 'Location: /'. DX_ROOT_PATH .'user/albums/index';
        $args = explode('/', $args);
        if(count($args) > 0){
            $id = $args[0];
            if(count($args) > 1){
                if($args[1] === 'categories'){
                    $path = 'Location: /'. DX_ROOT_PATH .'user/categories/albums';
                }

                if($args[1] === 'home'){
                    $path = 'Location: /'. DX_ROOT_PATH .'user/home/index';
                }
                else{
                    $template_name = DX_ROOT_DIR . '/views/elements/cannot_find_resource.php';
                    include_once $this->layout;
                    die;
                }
            }
        }

        if ($id != null) {
            $album = $this->models['album']->get_by_id($id);

            if ($album != null) {

                $user_id = $this->logged_user['id'];
                $album_id = $id;

                $vote = $this->models['album_vote']->find(array(
                    'where' => 'album_id = ' . $album_id . ' and user_id = ' . $user_id
                ));

                if ( $vote != null ) {
                    if ($vote[0]['vote'] === '1') {
                        $vote[0]['vote'] = 0;
                    }else{
                        $vote[0]['vote'] = 1;
                    }

                    $this->models['album_vote']->update($vote[0], array('user_id', 'album_id'));
                }else{
                    $new_vote = array(
                        'vote' => 1,
                        'user_id' => $user_id,
                        'album_id' => $album_id
                    );

                    $this->models['album_vote']->add($new_vote);
                }

                header($path);
                die;
            }
        }
    }
}