<?php //>

use dungeons\{Config,Message};
use dungeons\view\Twig;

$path = $controller->node();

$result['path'] = $path;

//--

$actions = [];

if ($controller->hasPermission("{$path}/")) {
    $actions[] = [
        'class' => Config::get('backend.edit.button'),
        'icon' => Config::get('backend.edit.icon'),
        'label' => Message::get('backend.edit')
    ];
}

$result['actions'] = $actions;

//--

$result['breadcrumbs'] = $controller->createBreadcrumbs([]);

//--

$result['styles'] = [
    ['label' => Message::get('bundle.name'), 'name' => 'name', 'readonly' => true, 'type' => 'text'],
    ['label' => Message::get('bundle.remark'), 'name' => 'remark', 'readonly' => true, 'type' => 'text'],
];

//--

(new Twig('backend/list.twig'))->render($controller, $form, $result);
