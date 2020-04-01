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
    'path' => preg_replace('/^\/backend\/(.+)$/', '$1/new', $controller->path()),
];

$result['controls'] = $controls;

//--

$operations = [];

$operations[] = [
    'class' => $cfg['edit.button'],
    'icon' => $cfg['edit.icon'],
    'label' => Message::get('backend.edit'),
];

$operations[] = [
    'class' => $cfg['delete.button'],
    'icon' => $cfg['delete.icon'],
    'label' => Message::get('backend.delete'),
    'method' => 'delete',
];

$result['operations'] = $operations;

//--

require 'breadcrumb.php';

//--

$styles = [];

foreach ($controller->columns() ?? $table->getColumns() as $name => $column) {
    $style = [
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'parameter' => $column->parameter(),
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

(new Twig('backend/list.twig'))->render($controller, $form, $result);
