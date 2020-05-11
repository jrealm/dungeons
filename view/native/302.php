<?php //>

if (defined('AJAX') && AJAX) {
    $result = [
        'type' => 'location',
        'path' => $result['path'],
    ];

    resolve('raw.php')->render($controller, $form, $result);
} else {
    header("Location: {$result['path']}");
}
