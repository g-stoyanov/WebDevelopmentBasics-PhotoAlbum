<h2>Add Photo</h2>
<form method="POST" enctype="multipart/form-data">
    <p>
        Photo Name: <input type="text" name="name" />
    </p>
    <p>
        Photo Album: <select name="album_id">
            <option value=""></option>
            <?php
            foreach($albums as $album)
            {
                $album['name'] = htmlspecialchars($album['name']);
                echo '<option value="'. $album['id'] .'">'. $album['name'] .'</option>';
            }
            ?>
        </select>
    </p>
    <p>
        Your Photo: <input type="file" name="file" size="25" />
    </p>

    <input type="hidden" name="user_id" value="<?php echo $this->logged_user['id'] ?>" />
    <input type="submit" />
</form>