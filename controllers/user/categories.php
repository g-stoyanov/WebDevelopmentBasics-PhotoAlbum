<?php

namespace User\Controllers;

class Categories_Controller extends User_Controller {

    protected $layout;
    protected $views_dir;

    public function __construct() {
        parent::__construct(get_class(),
            $models = array(
                'category' => 'category',
                'album' => 'album',
                'category_vote' => 'category_vote',
                'album_vote' => 'album_vote'
            ),
            'views/user/categories/');
    }

    public function index() {
        $categories = $this->models['category']->find();

        $columns = 'SUM(vote)';

        for($i = 0; $i < count($categories); $i++) {
            $category_votes = $this->models['category_vote']->find(array(
                'where' => 'category_id = ' . $categories[$i]['id'], 'columns' => $columns
            ));

            $category_user_vote = $this->models['category_vote']->find(array(
                'where' => 'category_id = ' . $categories[$i]['id'] . ' and user_id = ' . $this->logged_user['id'],
                'columns' => $columns
            ));

            $albums = array('albums' => count($this->models['album']->find(array('where' => 'category_id = ' . $categories[$i]['id']))));

            $cat_votes = array('votes' => 0);
            if(count($category_votes) > 0){
                $cat_votes = array('votes' => $category_votes[0][$columns] ? $category_votes[0][$columns] : 0);
            }

            $user_vote = array('user_vote' => 0);
            if(count($category_user_vote) > 0){
                $user_vote = array('user_vote' => $category_user_vote[0][$columns] ? $category_user_vote[0][$columns] : 0);
            }

            $categories[$i] = array_merge( $categories[$i], $cat_votes );
            $categories[$i] = array_merge( $categories[$i], $user_vote );
            $categories[$i] = array_merge( $categories[$i], $albums );
        }

        $template_name = DX_ROOT_DIR . $this->views_dir . 'index.php';

        include_once $this->layout;
    }

    public function albums( $id ) {

        $category = $this->models['category']->get_by_id($id);

        $albums = $this->models['album']->find(array('where' => 'category_id = ' . $id, 'order' => 'id'));

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

        $template_name = DX_ROOT_DIR . $this->views_dir . 'albums.php';

        include_once $this->layout;
    }

    public function vote( $id ) {
        if ($id != null) {
            $category = $this->models['category']->get_by_id($id);

            if ($category != null) {

                $user_id = $this->logged_user['id'];
                $category_id = $id;

                $vote = $this->models['category_vote']->find(array(
                    'where' => 'category_id = ' . $category_id . ' and user_id = ' . $user_id
                ));

                if ( $vote != null ) {
                    if ($vote[0]['vote'] === '1') {
                        $vote[0]['vote'] = 0;
                    }else{
                        $vote[0]['vote'] = 1;
                    }

                    $this->models['category_vote']->update($vote[0], array('user_id', 'category_id'));
                }else{
                    $new_vote = array(
                        'vote' => 1,
                        'user_id' => $user_id,
                        'category_id' => $category_id
                    );

                    $this->models['category_vote']->add($new_vote);
                }

                header('Location: /'. DX_ROOT_PATH .'user/categories/index');
                die;
            }
        }
    }
}