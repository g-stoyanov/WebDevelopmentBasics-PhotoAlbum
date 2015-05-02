<?php

namespace User\Controllers;

class Home_Controller extends User_Controller
{

    public function __construct()
    {
        parent::__construct(get_class(),
            $models = array(
                'album' => 'album',
                'category' => 'category',
                'photo' => 'photo',
                'album_vote' => 'album_vote'
            ),
            'views/user/home/');
    }

    public function index()
    {
        $albums = $this->models['album']->get_top_albums();

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
}
