<?php //>

use dungeons\Message;

$node = $controller->menu()['parent'];

$result['path'] = $node;

//--

$buttons = $controller->buttons() ?? [];

$buttons[] = [
    'class' => cfg('backend.edit.cancel.button'),
    'i18n' => 'backend.edit.cancel',
    'method' => 'cancel',
    'ranking' => 100,
];

if (!$controller->readonly() && $controller->hasPermission("{$node}/update")) {
    $buttons[] = [
        'class' => cfg('backend.edit.button'),
        'i18n' => 'backend.edit.submit',
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

$styles = [];

foreach ($controller->columns() ?? $table->getColumns() as $name => $column) {
    $readonly = $column->readonly();

    $style = [
        'column' => $column,
        'disabled' => $readonly || $column->disabled(),
        'i18n' => "table/{$table->name()}.{$name}",
        'multilingual' => $column->multilingual(),
        'name' => $name,
        'pattern' => $column->pattern(),
        'required' => !$readonly && $column->required(),
        'tab' => $column->tab(),
        'type' => $column->invisible() ? 'hidden' : $column->formStyle(),
    ];

    if ($style['type'] !== 'hidden') {
        $options = $column->options();

        if ($options) {
            $style['options'] = Message::load("options/{$options}");

            if ($style['type'] !== 'select') {
                $style['type'] = 'radio';
            }
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

if ($table->versionable()) {
    $result['styles'][] = ['name' => '__version__', 'type' => 'hidden'];
}

//--

if ($controller->user()['id'] === 1) {
    $result['superuser'] = true;
}

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
