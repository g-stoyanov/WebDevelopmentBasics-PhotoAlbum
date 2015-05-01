<h2>Top 5 Albums</h2>
<?php
echo "<ul>";
foreach( $albums as $album ) {
    $album_name = htmlspecialchars($album['name']);
    $root_path = DX_ROOT_PATH;
    echo "<li><div class='album'>";
    echo "<h3>{$album_name}</h3>";
    echo "<p>Rating: {$album['votes']}</p>";
    echo "</div></li>";
}
echo "</ul>";