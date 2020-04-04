<?php //>

use dungeons\{Config,Message};
use dungeons\view\Twig;

$id = $controller->args()[1];
$menu = $controller->menu();

$result['path'] = $menu['parent'];
$result['title'] = $menu['title'];
$result['sub_title'] = $id;

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

$result['data']['.title'] = $id;

$result['breadcrumbs'] = $controller->createBreadcrumbs([$result['data']]);

//--

$styles = [];

foreach ($result['data'] as $name => $ignore) {
    if ($name[0] === '.') {
        continue;
    }

    $style = $result['styles'][$name] ?? ['column' => 'Text'];
    $column = Config::load("column/{$style['column']}");

    $style['label'] = $name;
    $style['name'] = $name;
    $style['pattern'] = $style['pattern'] ?? @$column['pattern'];
    $style['type'] = $column['formStyle'];

    $styles[] = $style;
}

$result['styles'] = $styles;

//--

$result['data']['id'] = $id;

//--

(new Twig('backend/view.twig'))->render($controller, $form, $result);
