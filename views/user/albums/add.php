<form method="POST">
    <p>
        Album Name: <input type="text" name="name" />
    </p>
    <p>
        Album Category: <select name="category_id">
            <option value=""></option>
            <?php
            foreach($categories as $category)
            {
                $category['name'] = htmlspecialchars($category['name']);
                echo '<option value="'. $category['id'] .'">'. $category['name'] .'</option>';
            }
            ?>
        </select>
    </p>
    <input type="hidden" name="user_id" value="<?php echo $this->logged_user['id'] ?>" />
    <input type="submit" />
</form>