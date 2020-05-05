<?php //>

use dungeons\Config;
use dungeons\Message;
use dungeons\view\Twig;

$node = $controller->menu()['parent'];

$result['path'] = preg_replace('/^\/backend\/(.+)\/[\w]+$/', '$1', $controller->path());

//--

$buttons = [];

$buttons[] = [
    'class' => Config::get('backend.new.cancel.button'),
    'label' => Message::get('backend.new.cancel'),
    'method' => 'cancel',
    'ranking' => 100,
];

if ($controller->hasPermission("{$node}/insert")) {
    $buttons[] = [
        'class' => Config::get('backend.new.submit.button'),
        'label' => Message::get('backend.new.submit'),
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
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'pattern' => $column->pattern(),
        'placeholder' => $labels["{$name}.blankPlaceholder"] ?? @$labels["{$name}.placeholder"],
        'remark' => $labels["{$name}.blankRemark"] ?? @$labels["{$name}.remark"],
        'required' => $column->required(),
        'type' => $column->invisible() ? 'hidden' : $column->blankStyle() ?? $column->formStyle(),
    ];

    if ($style['type'] !== 'hidden') {
        $options = $column->options();

        if ($options) {
            $style['options'] = Message::load("options/{$options}");
            $style['type'] = 'radio';
        } else if (key_exists($name, $bundles)) {
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
        $result['data'] = json_decode(base64_urldecode($form['d']), true);
    }
    $view = $controller->customView() ?? 'backend/view.twig';
}

(new Twig($view))->render($controller, $form, $result);
