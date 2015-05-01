<?php echo"<h2>Add Comment for Photo {$photo['name']}</h2>" ?>
<form method="POST" enctype="multipart/form-data">
    <p>
        Comment: <textarea name="text" cols="40" rows="5" ></textarea>
    </p>

    <input type="hidden" name="user_id" value="<?php echo $this->logged_user['id'] ?>" />
    <input type="submit" />
</form>