<?php //>

if (defined('AJAX') && AJAX) {
    $result = [
        'type' => 'location',
        'path' => $result['path'],
    ];

    require 'raw.php';
} else {
    header("Location: {$result['path']}");
}
