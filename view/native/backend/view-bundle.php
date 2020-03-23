<?php //>

use dungeons\Config;
use dungeons\Message;
use dungeons\Resource;
use dungeons\view\Twig;

$cfg = Config::load('backend');
$id = $action->args()[0];
$menus = Resource::loadMenu(explode('|', $cfg['menus']));
$path = preg_replace('/\/backend\/(.*)/', '$1', $action->name());
$node = $menus[$path];

$result['title'] = "{$node['title']} :: {$id}";

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
    $style = $result['styles'][$name] ?? ['type' => 'text'];

    $style['label'] = $name;
    $style['name'] = $name;

    $styles[] = $style;
}

$result['styles'] = $styles;

//--

$result['data']['id'] = $id;

//--

(new Twig('backend/view.twig'))->render($action, $form, $result);
