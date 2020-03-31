<?php //>

use dungeons\Message;
use dungeons\view\Twig;

require 'declaration.php';

$result['path'] = $node['parent'];

//--

$buttons = [];

$buttons[] = [
    'class' => $cfg['new.cancel.button'],
    'label' => Message::get('backend.new.cancel'),
];

$buttons[] = [
    'class' => $cfg['new.submit.button'],
    'label' => Message::get('backend.new.submit'),
    'method' => 'insert',
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
