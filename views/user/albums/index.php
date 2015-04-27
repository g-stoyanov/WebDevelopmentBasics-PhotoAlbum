<?php
foreach( $albums as $album ) {
    $album_name = htmlspecialchars($album['name']);
    echo "{$album_name} <br />";
}