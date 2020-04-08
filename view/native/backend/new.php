<?php //>

use dungeons\{Config,Message};
use dungeons\view\Twig;

$node = $controller->menu()['parent'];

$result['path'] = preg_replace('/^\/backend\/(.+)\/[\w]+$/', '$1', $controller->path());

//--

$buttons = [];

$buttons[] = [
    'class' => Config::get('backend.new.cancel.button'),
    'label' => Message::get('backend.new.cancel'),
    'method' => 'cancel',
];

if ($controller->hasPermission("{$node}/insert")) {
    $buttons[] = [
        'class' => Config::get('backend.new.submit.button'),
        'label' => Message::get('backend.new.submit'),
        'method' => 'insert',
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
        'label' => $labels[$name] ?? "[{$name}]",
        'name' => $name,
        'pattern' => $column->pattern(),
        'placeholder' => $labels["{$name}.blankPlaceholder"] ?? @$labels["{$name}.placeholder"],
        'remark' => $labels["{$name}.blankRemark"] ?? @$labels["{$name}.remark"],
        'required' => $column->required(),
        'type' => $column->invisible() ? 'hidden' : $column->blankStyle() ?? $column->formStyle(),
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
