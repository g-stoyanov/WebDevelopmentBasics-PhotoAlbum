<h2>All Albums</h2>
<?php
echo "<ul>";
foreach( $albums as $album ) {
    $album_name = htmlspecialchars($album['name']);
    $vote_text = $album['user_vote'] === 0 ? 'Like' : 'Dislike';
    $root_path = DX_ROOT_PATH;
    echo "<li><div class='album'>";
    echo "<h3><a href='/{$root_path}user/albums/photos/{$album['id']}'>{$album_name}</a></h3>";
    echo "<p>Rating: {$album['votes']}</p><p><a href='vote/{$album['id']}'> {$vote_text} </a></p>";
    echo "</div></li>";
}
echo "</ul>";