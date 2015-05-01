<?php
foreach( $photos as $photo ) {
    $file_parts = explode('/', $photo['file']);
    $thumbnail = $file_parts[0] . '/thumb_' . $file_parts[1];
    $imageData = base64_encode(file_get_contents($thumbnail));
    $src = 'data: '. _mime_content_type($thumbnail).';base64,'.$imageData;
    $photo_name = htmlspecialchars($photo['name']);
    echo "<a href='/WebDevelopmentBasics-PhotoAlbum/user/photo/view/{$photo['id']}'> {$photo_name}</a> <br />";
    echo "<a href='/WebDevelopmentBasics-PhotoAlbum/user/photo/view/{$photo['id']}'> <img src='{$src}' alt='{$photo_name}'> </a>";
    echo "<br />";
    echo "<br />";
}