<?php

namespace User\Controllers;

class Photo_Controller extends User_Controller {

    protected $layout;
    protected $views_dir;

    public function __construct() {
        parent::__construct(get_class(),
            $models = array(
                'photo' => 'photo',
                'album' => 'album',
                'photo_comment' => 'photo_comment',
                'user' => 'user'
            ),
            'views/user/photo/');
    }

    public function view( $id ) {
        $template_name = DX_ROOT_DIR . '/views/elements/cannot_find_resource.php';


        if( $id != null){
            $photo = $this->models['photo']->get_by_id( $id );

            if($photo != null){
                $comments = $this->models['photo_comment']->find(array(
                    'where' => 'photo_id = ' . $id,
                    'order' => 'id'
                ));

                for($i = 0; $i < count($comments); $i++) {
                    $user = $this->models['user']->get_by_id($comments[$i]['user_id']);

                    $user = array('username' => $user['username']);

                    $comments[$i] = array_merge( $comments[$i], $user );
                }

                $template_name = DX_ROOT_DIR . $this->views_dir . 'view.php';
            }
        }



        include_once $this->layout;
    }

    public function add() {
        if( ! empty ( $_POST['name'] ) &&  ! empty ( $_POST['album_id'] ) ) {

            if($_FILES['file']['name'])
            {
                $valid_file = true;

                //if no errors...
                if(!$_FILES['file']['error'])
                {
                    $file_type = explode('/', $_FILES['file']['type']);
                    //now is the time to modify the future file name and validate the file
                    $extension = end(explode('.', $_FILES['file']['name']));
                    $new_file_name = uniqid() . '.' . $extension; //rename file
                    if($_FILES['file']['size'] > (1024000) || $file_type[0] != 'image') //can't be larger than 1 MB
                    {
                        $valid_file = false;
                        $message = 'Oops!  Your file\'s size is to large.';
                    }

                    //if the file has passed the test
                    if($valid_file)
                    {
                        //move it to where we want it to be
                        move_uploaded_file($_FILES['file']['tmp_name'], 'photos/'.$new_file_name);
                        $resizer = new \Eventviva\ImageResize('photos/'.$new_file_name);
                        $resizer->resizeToWidth(200);
                        $resizer->save('photos/' . 'thumb_' . $new_file_name);

                        $name = $_POST['name'];
                        $file = 'photos/'.$new_file_name;
                        $album_id = $_POST['album_id'];
                        $user_id = $_POST['user_id'];

                        $new_photo = array(
                            'name' => $name,
                            'file' => $file,
                            'album_id' => $album_id,
                            'user_id' => $user_id
                        );

                        $this->models['photo']->add($new_photo);

                        $message = 'Congratulations!  Your file was accepted.';
                    }
                }
                //if there is an error...
                else
                {
                    //set that to be the returned message
                    $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
                }
            }
        }

        $albums = $this->models['album']->find(array(
            'where' => 'user_id = ' . $this->logged_user['id'],
            'order' => 'id'
        ));

        $template_name = DX_ROOT_DIR . $this->views_dir . 'add.php';

        include_once $this->layout;
    }

    public function download( $id ) {
        $template_name = DX_ROOT_DIR . '/views/elements/cannot_find_resource.php';

        if( $id != null){
            $photo = $this->models['photo']->get_by_id( $id );

            if($photo != null){

                $file = $photo['file'];

                if (file_exists($file)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename='.basename($file));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    readfile($file);
                    exit;
                }

                $template_name = DX_ROOT_DIR . $this->views_dir . 'view.php';
            }
        }

        include_once $this->layout;
    }


    public function comment( $id ) {
        if(! empty($id)) {
            $photo = $this->models['photo']->get_by_id($id);

            if ($photo != null) {
                if (!empty ($_POST['text'])) {
                    $text = $_POST['text'];
                    $user_id = $_POST['user_id'];

                    $new_comment = array(
                        'text' => $text,
                        'user_id' => $user_id,
                        'photo_id' => $photo['id']
                    );

                    $this->models['photo_comment']->add($new_comment);

                    header('Location: /' . DX_ROOT_PATH . 'user/photo/view/' . $id);
                    die;
                }else{
                    $template_name = DX_ROOT_DIR . $this->views_dir . 'comment.php';

                    include_once $this->layout;
                }
            } else {
                $template_name = DX_ROOT_DIR . '/views/elements/cannot_find_resource.php';
                include_once $this->layout;
                die;
            }
        }else{
            $template_name = DX_ROOT_DIR . '/views/elements/cannot_find_resource.php';
            include_once $this->layout;
            die;
        }

    }
}