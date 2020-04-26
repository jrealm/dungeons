<?php //>

use dungeons\Config;
use dungeons\Message;
use dungeons\view\Twig;

$node = $controller->node();
$path = preg_replace('/^\/backend\/(.+)$/', '$1', $controller->path());

$result['path'] = $path;

//--

$controls = [];

if ($controller->hasPermission("{$node}/new")) {
    $controls[] = [
        'class' => Config::get('backend.new.button'),
        'icon' => Config::get('backend.new.icon'),
        'label' => Message::get('backend.new'),
        'path' => "{$path}/new",
    ];
}

$result['controls'] = $controls;

//--

$actions = [];

if ($controller->hasPermission("{$node}/")) {
    $actions[] = [
        'class' => Config::get('backend.edit.button'),
        'icon' => Config::get('backend.edit.icon'),
        'label' => Message::get('backend.edit'),
    ];
}

if ($controller->hasPermission("{$node}/delete")) {
    $actions[] = [
        'class' => Config::get('backend.delete.button'),
        'icon' => Config::get('backend.delete.icon'),
        'label' => Message::get('backend.delete'),
        'method' => 'delete',
    ];
}

$result['actions'] = $actions;

//--

$table = $controller->table();
$list = $table->model()->parents($form);

$result['breadcrumbs'] = $controller->createBreadcrumbs($list);

//--

$titles = array_filter(array_column($list, '.title'), 'is_string');

$result['sub_title'] = array_pop($titles);

//--

$orders = [];

foreach ($result['orders'] as $index => $name) {
    if ($name[0] === '-') {
        $orders[substr($name, 1)] = -1 - $index;
    } else {
        $orders[$name] = $index + 1;
    }
}

$result['orders'] = $orders;

//--

$labels = Message::load("table/{$table->name()}");
$styles = [];

foreach ($controller->columns() ?? $table->getColumns() as $name => $column) {
    if ($column->association() || $column->invisible()) {
        continue;
    }

    if ($column->isCounter()) {
        if (!$controller->hasPermission("{$node}/{$column->parameter()}")) {
            continue;
        }
    }

    $style = [
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'parameter' => $column->parameter(),
        'type' => $column->listStyle(),
        'unordered' => $column->unordered(),
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
        $style['type'] = 'select';
    }

    $styles[] = $style;
}

$result['styles'] = $controller->remix($styles, $list);

//--

$result['parameters'] = array_intersect_key($form, array_flip(['o', 'p', 's']));

//--

(new Twig('backend/list.twig'))->render($controller, $form, $result);
