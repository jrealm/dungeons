<?php //>

use dungeons\Config;
use dungeons\Message;

$node = $controller->menu()['parent'];

$result['path'] = $node;

//--

$buttons = $controller->buttons() ?? [];

$buttons[] = [
    'class' => Config::get('backend.edit.cancel.button'),
    'label' => Message::get('backend.edit.cancel'),
    'method' => 'cancel',
    'ranking' => 100,
];

if ($controller->hasPermission("{$node}/update")) {
    $buttons[] = [
        'class' => Config::get('backend.edit.button'),
        'label' => Message::get('backend.edit.submit'),
        'method' => 'update',
        'ranking' => 200,
    ];
}

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
    $readonly = $column->readonly();

    $style = [
        'column' => $column,
        'disabled' => $readonly || $column->disabled(),
        'label' => $labels[$name] ?? "[{$name}]",
        'multilingual' => $column->multilingual(),
        'name' => $name,
        'pattern' => $column->pattern(),
        'placeholder' => @$labels["{$name}.placeholder"],
        'remark' => @$labels["{$name}.remark"],
        'required' => !$readonly && $column->required(),
        'type' => $column->invisible() ? 'hidden' : $column->formStyle(),
    ];

    if ($style['type'] !== 'hidden') {
        $options = $column->options();

        if ($options) {
            $style['options'] = Message::load("options/{$options}");
            $style['type'] = 'radio';
        } else if (key_exists($name, $bundles)) {
            $style['multiple'] = $column->multiple();
            $style['options'] = $bundles[$name];
            $style['relation'] = $relations[$name];
            $style['type'] = 'select';
        }
    }

    $styles[] = $style;
}

$result['styles'] = $controller->remix($styles, $list);

//--

switch (@$form['args']) {
case 'modal':
    $view = 'backend/modal-view.twig';
    break;
default:
    if (@$form['d']) {
        $result['data'] = json_decode(urldecode(base64_urldecode($form['d'])), true);
    }
    $view = $controller->customView() ?? 'backend/view.twig';
}

resolve($view)->render($controller, $form, $result);
