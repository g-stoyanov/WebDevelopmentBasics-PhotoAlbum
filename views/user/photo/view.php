<?php

$file_parts = explode('/', $photo['file']);
$thumbnail = $file_parts[0] . '/thumb_' . $file_parts[1];
$imageData = base64_encode(file_get_contents($thumbnail));
$src = 'data: '. _mime_content_type($thumbnail).';base64,'.$imageData;
$photo_name = htmlspecialchars($photo['name']);
$root_path = DX_ROOT_PATH;
echo "{$photo_name} <br />";
echo "<img src='{$src}' alt='{$photo_name}'>";
echo "<br />";
echo "<a href='/{$root_path}user/photo/download/{$photo['id']}'> Download </a>";
echo "<a href='/{$root_path}user/photo/comment/{$photo['id']}'> Comment </a>";
echo "<br />";
echo "<br />";
echo "Comments";
foreach( $comments as $comment ) {
    echo "<p>user:{$comment['username']}</p>";
    echo "<p>comment:{$comment['text']}</p><br />";
}


