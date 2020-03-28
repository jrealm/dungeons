<?php //>

use dungeons\Message;
use dungeons\view\Twig;

require 'declaration.php';

$result['sub_title'] = $table->model()->toString($result['data']);

//--

$buttons = [];
$parent = $node['parent'];

$buttons[] = [
    'class' => $cfg['edit.cancel.button'],
    'label' => Message::get('backend.edit.cancel'),
    'path' => $parent,
];

$buttons[] = [
    'class' => $cfg['edit.button'],
    'label' => Message::get('backend.edit.submit'),
    'method' => 'update',
    'path' => $parent,
];

$result['buttons'] = $buttons;

//--

require 'breadcrumb.php';
require 'association.php';

//--

$styles = [];

foreach ($action->columns() ?? $table->getColumns() as $name => $column) {
    $style = [
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'pattern' => $column->pattern(),
        'placeholder' => @$labels["{$name}.placeholder"],
        'remark' => @$labels["{$name}.remark"],
        'required' => $column->required(),
        'type' => $column->formStyle(),
    ];

    $options = $column->options();

    if ($options) {
        $style['options'] = Message::load("options/{$options}");
    } else if (key_exists($name, $bundles)) {
        $style['options'] = $bundles[$name];
        $style['type'] = 'select';
    }

    $styles[] = $style;
}

$result['styles'] = $styles;

//--

(new Twig('backend/view.twig'))->render($action, $form, $result);
