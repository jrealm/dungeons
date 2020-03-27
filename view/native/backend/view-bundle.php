<?php //>

use dungeons\{Config,Message,Resource};
use dungeons\view\Twig;

$cfg = Config::load('backend');
$id = $action->args()[1];
$menus = Resource::loadMenu($cfg['menus']);
$path = preg_replace('/^\/backend\/(.+\/)[\w-]+$/', '$1', $action->path());
$node = @$menus[$path];

$result['title'] = $node['title'];
$result['sub_title'] = $id;

//--

$buttons = [];
$parent = $node['parent'];

$buttons[] = [
    'class' => $cfg['edit.cancel.button'],
    'label' => Message::get('backend.edit.cancel'),
    'path' => $parent,
];

$buttons[] = [
    'class' => $cfg['edit.button'],
    'label' => Message::get('backend.edit.submit'),
    'method' => 'update',
    'path' => $parent,
];

$result['buttons'] = $buttons;

//--

require 'breadcrumb.php';

//--

$styles = [];

foreach ($result['data'] as $name => $ignore) {
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

(new Twig('backend/view.twig'))->render($action, $form, $result);
