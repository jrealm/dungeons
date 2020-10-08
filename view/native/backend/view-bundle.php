<?php //>

use dungeons\db\column\Text;

$path = $controller->menu()['parent'];

$result['path'] = $path;

//--

$buttons = [];

$buttons[] = [
    'class' => cfg('backend.edit.cancel.button'),
    'i18n' => 'backend.edit.cancel',
    'method' => 'cancel',
    'ranking' => 100,
];

if ($controller->hasPermission("{$path}/update")) {
    $buttons[] = [
        'class' => cfg('backend.edit.button'),
        'i18n' => 'backend.edit.submit',
        'method' => 'update',
        'ranking' => 200,
    ];
}

$result['buttons'] = $buttons;

//--

$id = $controller->args()[1];
$result['sub_title'] = i18n($result['prefix'], $id);
$result['data']['.title'] = $result['sub_title'];
$result['breadcrumbs'] = $controller->createBreadcrumbs([$result['data']]);

//--

$prefix = $result['prefix'];
$styles = [];

foreach ($result['data'] as $name => $ignore) {
    if ($name[0] === '.') {
        continue;
    }

    $class = cfg("style/{$prefix}.{$name}", Text::class);
    $column = new $class();

    $style = [];
    $style['i18n'] = "{$prefix}.{$name}";
    $style['name'] = $name;
    $style['pattern'] = $style['pattern'] ?? $column->pattern();
    $style['type'] = $column->formStyle();

    $styles[] = $style;
}

$result['styles'] = $styles;

//--

$result['data']['id'] = $id;

//--

if ($controller->user()['id'] === 1) {
    $result['superuser'] = true;
}

resolve('backend/view.twig')->render($controller, $form, $result);
