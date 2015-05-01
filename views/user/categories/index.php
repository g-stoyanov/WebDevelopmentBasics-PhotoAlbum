<h2>Categories</h2>
<?php
echo "<ul>";
foreach( $categories as $category ) {
    $category_name = htmlspecialchars($category['name']);
    $vote_text = $category['user_vote'] === 0 ? 'Like' : 'Dislike';
    echo "<li><div class='category'>";
    echo "<h3><a href='albums/{$category['id']}'>{$category_name}</a></h3>";
    echo "<p>Albums: {$category['albums']}</p>";
    echo "<p>Rating: {$category['votes']}</p><p><a href='vote/{$category['id']}'> {$vote_text} </a></p>";
    echo "</div></li>";
}
echo "</ul>";