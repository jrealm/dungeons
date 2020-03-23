<?php //>

use dungeons\Message;
use dungeons\view\Twig;

require 'declaration.php';

//--

$buttons = [];
$parent = $node['parent'];

$buttons[] = [
    'class' => $cfg['new.cancel.button'],
    'label' => Message::get('backend.new.cancel'),
    'path' => $parent,
];

$buttons[] = [
    'class' => $cfg['new.submit.button'],
    'label' => Message::get('backend.new.submit'),
    'method' => 'insert',
    'path' => $parent,
];

$result['buttons'] = $buttons;

//--

require 'breadcrumb.php';
require 'association.php';

//--

$styles = [];

foreach ($action->columns() ?? $action->table()->getColumns() as $name => $column) {
    $style = [
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'pattern' => $column->pattern(),
        'placeholder' => $labels["{$name}.blankPlaceholder"] ?? @$labels["{$name}.placeholder"],
        'remark' => $labels["{$name}.blankRemark"] ?? @$labels["{$name}.remark"],
        'required' => $column->required(),
        'type' => $column->blankStyle() ?? $column->formStyle(),
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
