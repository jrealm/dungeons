<?php //>

use dungeons\{Config,Message};
use dungeons\view\Twig;

$result['path'] = $controller->menu()['parent'];

//--

$buttons = [];

$buttons[] = [
    'class' => Config::get('backend.edit.cancel.button'),
    'label' => Message::get('backend.edit.cancel'),
    'method' => 'cancel',
];

$buttons[] = [
    'class' => Config::get('backend.edit.button'),
    'label' => Message::get('backend.edit.submit'),
    'method' => 'update',
];

$result['buttons'] = $buttons;

//--

$table = $controller->table();
$list = $table->model()->parents($result['data']);
$list[] = $result['data'];

$result['breadcrumbs'] = $controller->createBreadcrumbs($list);

//--

$titles = array_filter(array_column($list, '.title'), 'is_string');

$result['sub_title'] = array_pop($titles);

//--

require 'association.php';

//--

$labels = Message::load("table/{$table->name()}");
$styles = [];

foreach ($controller->columns() ?? $table->getColumns() as $name => $column) {
    $style = [
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'pattern' => $column->pattern(),
        'placeholder' => @$labels["{$name}.placeholder"],
        'remark' => @$labels["{$name}.remark"],
        'required' => $column->required(),
        'type' => $column->invisible() ? 'hidden' : $column->formStyle(),
    ];

    $options = $column->options();

    if ($options) {
        $style['options'] = Message::load("options/{$options}");
        $style['type'] = 'radio';
    } else if (key_exists($name, $bundles)) {
        $style['options'] = $bundles[$name];
        $style['type'] = 'select';
    }

    $styles[] = $style;
}

$result['styles'] = $styles;

//--

(new Twig('backend/view.twig'))->render($controller, $form, $result);
