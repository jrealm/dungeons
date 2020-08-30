<?php //>

use dungeons\Message;

$node = $controller->menu()['parent'];

$result['path'] = preg_replace('/^\/backend\/(.+)\/[\w]+$/', '$1', $controller->path());

//--

$buttons = $controller->buttons() ?? [];

$buttons[] = [
    'class' => cfg('backend.new.cancel.button'),
    'label' => i18n('backend.new.cancel'),
    'method' => 'cancel',
    'ranking' => 100,
];

$button = $controller->button();

if ($button) {
    $buttons[] = $button;
} else if ($controller->hasPermission("{$node}/insert")) {
    $buttons[] = [
        'class' => cfg('backend.new.submit.button'),
        'label' => i18n('backend.new.submit'),
        'method' => 'insert',
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
    $style = [
        'column' => $column,
        'disabled' => $column->disabled(),
        'label' => $labels[$name] ?? "[{$name}]",
        'multilingual' => $column->multilingual(),
        'name' => $name,
        'pattern' => $column->pattern(),
        'placeholder' => $labels["{$name}.blankPlaceholder"] ?? @$labels["{$name}.placeholder"],
        'remark' => $labels["{$name}.blankRemark"] ?? @$labels["{$name}.remark"],
        'required' => $column->required(),
        'tab' => $column->tab(),
        'type' => $column->invisible() ? 'hidden' : $column->blankStyle() ?? $column->formStyle(),
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

//--

switch (@$form['args']) {
case 'modal':
    $view = 'backend/modal-blank.twig';
    break;
default:
    if (@$form['d']) {
        $result['data'] = json_decode(urldecode(base64_urldecode($form['d'])), true);
    }
    $view = $controller->customView() ?? 'backend/view.twig';
}

resolve($view)->render($controller, $form, $result);
