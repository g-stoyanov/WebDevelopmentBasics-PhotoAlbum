<?php
foreach( $albums as $album ) {
    $album_name = htmlspecialchars($album['name']);
    echo "<a href='photos/{$album['id']}'>{$album_name}</a> <br />";
}