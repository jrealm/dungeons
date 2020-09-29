<?php //>

$path = $controller->node();

$result['path'] = $path;

//--

$actions = [];

if ($controller->hasPermission("{$path}/")) {
    $actions[] = [
        'class' => cfg('backend.edit.button'),
        'i18n' => 'backend.edit',
        'icon' => cfg('backend.edit.icon'),
        'ranking' => 100,
    ];
}

$result['actions'] = $actions;

//--

$result['breadcrumbs'] = $controller->createBreadcrumbs([]);

//--

$result['styles'] = [
    ['i18n' => 'bundle.name', 'name' => 'name', 'readonly' => true, 'type' => 'text', 'unordered' => true],
    ['i18n' => 'bundle.remark', 'name' => 'remark', 'readonly' => true, 'type' => 'text', 'unordered' => true],
];

//--

resolve('backend/list.twig')->render($controller, $form, $result);
