<?php //>

$path = $controller->node();

$result['path'] = $path;

//--

$actions = [];

if ($controller->hasPermission("{$path}/")) {
    $actions[] = [
        'class' => cfg('backend.edit.button'),
        'icon' => cfg('backend.edit.icon'),
        'label' => i18n('backend.edit'),
        'ranking' => 100,
    ];
}

$result['actions'] = $actions;

//--

$result['breadcrumbs'] = $controller->createBreadcrumbs([]);

//--

$result['styles'] = [
    ['label' => i18n('bundle.name'), 'name' => 'name', 'readonly' => true, 'type' => 'text', 'unordered' => true],
    ['label' => i18n('bundle.remark'), 'name' => 'remark', 'readonly' => true, 'type' => 'text', 'unordered' => true],
];

//--

resolve('backend/list.twig')->render($controller, $form, $result);
