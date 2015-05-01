<?php

        $file_parts = explode('/', $photo['file']);
        $thumbnail = $file_parts[0] . '/thumb_' . $file_parts[1];
        $imageData = base64_encode(file_get_contents($thumbnail));
        $src = 'data: '. _mime_content_type($thumbnail).';base64,'.$imageData;
        $photo_name = htmlspecialchars($photo['name']);
        echo "{$photo_name} <br />";
        echo "<img src='{$src}' alt='{$photo_name}'>";


