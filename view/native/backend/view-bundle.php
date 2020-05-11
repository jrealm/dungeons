<?php //>

use dungeons\Config;
use dungeons\db\column\Text;
use dungeons\Message;

$path = $controller->menu()['parent'];

$result['path'] = $path;

//--

$buttons = [];

$buttons[] = [
    'class' => Config::get('backend.edit.cancel.button'),
    'label' => Message::get('backend.edit.cancel'),
    'method' => 'cancel',
    'ranking' => 100,
];

if ($controller->hasPermission("{$path}/update")) {
    $buttons[] = [
        'class' => Config::get('backend.edit.button'),
        'label' => Message::get('backend.edit.submit'),
        'method' => 'update',
        'ranking' => 200,
    ];
}

$result['buttons'] = $buttons;

//--

$id = $controller->args()[1];
$result['data']['.title'] = $id;

$result['breadcrumbs'] = $controller->createBreadcrumbs([$result['data']]);
$result['sub_title'] = $id;

//--

$styles = [];

foreach ($result['data'] as $name => $ignore) {
    if ($name[0] === '.') {
        continue;
    }

    $style = $result['styles'][$name] ?? ['column' => Text::class];
    $column = new $style['column']();

    $style['label'] = $name;
    $style['name'] = $name;
    $style['pattern'] = $style['pattern'] ?? $column->pattern();
    $style['type'] = $column->formStyle();

    $styles[] = $style;
}

$result['styles'] = $styles;

//--

$result['data']['id'] = $id;

//--

resolve('backend/view.twig')->render($controller, $form, $result);
