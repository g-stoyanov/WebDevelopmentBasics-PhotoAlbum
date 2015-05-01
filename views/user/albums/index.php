<?php
foreach( $albums as $album ) {
    $album_name = htmlspecialchars($album['name']);
    $vote_text = $album['user_vote'] === 0 ? 'Like' : 'Dislike';
    echo "<br /> <h3><a href='photos/{$album['id']}'>{$album_name}</a></h3>";
    echo "<p>Rating: {$album['votes']}</p><p><a href='vote/{$album['id']}'> {$vote_text} </a></p>";
}