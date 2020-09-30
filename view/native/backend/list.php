<?php //>

use dungeons\Message;

$node = $controller->node();
$path = preg_replace('/^\/backend\/(.+)$/', '$1', $controller->path());

$result['path'] = $path;

//--

$controls = $controller->controls() ?? [];

if ($controller->hasPermission("{$node}/new")) {
    $controls[] = [
        'class' => cfg('backend.new.button'),
        'i18n' => 'backend.new',
        'icon' => cfg('backend.new.icon'),
        'path' => "{$path}/new",
        'ranking' => 100,
    ];
}

if ($controller->hasPermission("{$node}/delete")) {
    $controls[] = [
        'class' => cfg('backend.multiple-delete.button'),
        'i18n' => 'backend.delete',
        'icon' => cfg('backend.delete.icon'),
        'least' => 1,
        'path' => "{$node}/delete",
        'ranking' => 200,
    ];
}

$controls[] = [
    'class' => cfg('backend.export.button'),
    'i18n' => 'backend.export',
    'icon' => cfg('backend.export.icon'),
    'least' => 0,
    'parameters' => array_intersect_key($form, array_flip(['g', 'o', 'q', 's'])) + ['t' => $controller->exportFormat()],
    'path' => $path,
    'ranking' => 300,
];

$result['controls'] = $controls;

//--

$actions = $controller->actions() ?? [];

if ($controller->hasPermission("{$node}/")) {
    $actions[] = [
        'class' => cfg('backend.edit.button'),
        'i18n' => 'backend.edit',
        'icon' => cfg('backend.edit.icon'),
        'ranking' => 100,
    ];
}

$result['actions'] = $actions;

//--

$result['buttons'] = $controller->buttons() ?? [];

//--

$table = $controller->table();
$list = $table->model()->parents($form);

$result['breadcrumbs'] = $controller->createBreadcrumbs($list);

//--

$titles = array_filter(array_column($list, '.title'), 'is_string');

$result['sub_title'] = array_pop($titles);

//--

require 'association.php';

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

$styles = [];

foreach ($controller->columns() ?? $table->getColumns() as $name => $column) {
    if (!$column->visible()) {
        if ($column->association() || $column->invisible()) {
            continue;
        }
    }

    if ($column->isCounter()) {
        if (!$controller->hasPermission("{$node}/{$column->relation()['alias']}")) {
            continue;
        }
    }

    $style = [
        'column' => $column,
        'i18n' => "table/{$table->name()}.{$name}",
        'label' => $column->label(),
        'name' => $name,
        'relation' => $column->relation(),
        'type' => $column->listStyle(),
        'unordered' => $column->unordered(),
    ];

    if (empty($style['type'])) {
        $style['readonly'] = !$column->editable();
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

$filters = [];

foreach ($controller->filters() ?? [] as $name => $column) {
    $filter = [
        'i18n' => "table/{$table->name()}.{$name}",
        'label' => $column->label(),
        'name' => $name,
        'pattern' => $column->pattern(),
        'search' => $column->searchStyle(),
        'type' => $column->formStyle(),
    ];

    $options = $column->options();

    if ($options) {
        $options = Message::load("options/{$options}");
    } else if (key_exists($name, $bundles)) {
        $options = $bundles[$name];
    }

    if ($options) {
        $filter['options'] = $options;
        $filter['search'] = null;
        $filter['type'] = 'select';
    }

    $filters[] = $filter;
}

$result['filters'] = $filters;

//--

if (!$filters) {
    $selected = false;

    foreach ($result['styles'] as $style) {
        if (@$style['unordered']) {
            continue;
        }

        if (@$style['relation'] && $style['relation']['type'] === 'association' && $style['column']->delegation()) {
            $name = $style['relation']['column']->name();

            $filter = [
                'label' => $style['label'],
                'name' => $name,
            ];

            $options = $bundles[$name];
        } else {
            $column = @$style['column'];

            $filter = [
                'i18n' => $style['i18n'],
                'label' => $style['label'],
                'name' => $style['name'],
                'pattern' => $column ? $column->pattern() : @$style['pattern'],
                'search' => $column ? $column->searchStyle() : null,
                'type' => $style['type'],
            ];

            $options = @$style['options'];
        }

        if (is_array($options)) {
            $filter['options'] = $options;
            $filter['search'] = null;
            $filter['type'] = 'select';
        }

        if (!$selected && $column && $column->inSearch()) {
            $filter['selected'] = true;
            $selected = true;
        }

        switch ($filter['type']) {
        case 'anchor':
        case 'html':
        case 'textarea':
            $filter['type'] = 'text';
        }

        $filters[] = $filter;
    }

    if ($filter) {
        if (!$selected) {
            $filters[0]['selected'] = true;
        }

        $result['simple_filters'] = $filters;
    }
}

//--

$result['parameters'] = array_intersect_key($form, array_flip(['g', 'o', 'p', 'q', 's']));

if ($result['parameters']) {
    $result['backward'] = ['r' => base64_urlencode(http_build_query($result['parameters']))];
}

if ($table->enableTime()) {
    $result['groups'] = $table->disableTime() ? [0, 1, 2, 3, 4] : [0, 1, 2, 3];
} else {
    $result['groups'] = $table->disableTime() ? [0, 1, 2, 4] : [];
}

//--

switch ($result['export']) {
case 'xlsx':
    $view = 'backend/export-xlsx.php';
    break;
default:
    $view = $controller->customView() ?? 'backend/list.twig';
}

resolve($view)->render($controller, $form, $result);
