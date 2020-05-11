<?php //>

use dungeons\Message;

$errors = [];
$table = $controller->table();
$labels = $table ? Message::load("table/{$table->name()}") : [];

foreach ($result as $error) {
    $name = $error['name'];
    $message = @$error['message'];

    if ($message === null) {
        $type = $error['type'];
        $template = @$labels["{$name}.{$type}"];

        if ($template === null) {
            $message = Message::get("validation.{$type}");
        } else {
            $message = render($template, $form);
        }
    }

    $errors[] = ['name' => $name, 'message' => $message];
}

$result = ['type' => 'validation', 'target' => @$form['form-id'], 'errors' => $errors];

require __DIR__ . '/../raw.php';
