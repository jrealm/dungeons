<?php //>

use dungeons\Message;
use dungeons\view\Twig;

require 'declaration.php';

$result['path'] = $path;

//--

$controls = [];

$controls[] = [
    'class' => $cfg['new.button'],
    'icon' => $cfg['new.icon'],
    'label' => Message::get('backend.new'),
    'path' => "{$path}/new",
];

$result['controls'] = $controls;

//--

$actions = [];

$actions[] = [
    'class' => $cfg['edit.button'],
    'icon' => $cfg['edit.icon'],
    'label' => Message::get('backend.edit'),
    'path' => $path,
];

$actions[] = [
    'class' => $cfg['delete.button'],
    'icon' => $cfg['delete.icon'],
    'label' => Message::get('backend.delete'),
    'method' => 'delete',
    'path' => $path,
];

$result['actions'] = $actions;

//--

require 'breadcrumb.php';

//--

$styles = [];

foreach ($action->columns() ?? $table->getColumns() as $name => $column) {
    $style = [
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'type' => $column->listStyle(),
    ];

    if (empty($style['type'])) {
        $style['readonly'] = true;
        $style['type'] = $column->formStyle();

        if ($style['type'] === 'hidden') {
            continue;
        }
    }

    $options = $column->options();

    if ($options) {
        $style['options'] = Message::load("options/{$options}");
    }

    $styles[] = $style;
}

$result['styles'] = $styles;

//--

(new Twig('backend/list.twig'))->render($action, $form, $result);
