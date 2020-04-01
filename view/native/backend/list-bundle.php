<?php //>

use dungeons\{Config,Message,Resource};
use dungeons\view\Twig;

$cfg = Config::load('backend');
$menus = Resource::loadMenu($cfg['menus']);
$path = preg_replace('/^\/backend\/(.+)$/', '$1', $controller->path());
$node = @$menus[$path];

$result['path'] = $path;
$result['title'] = $node['title'];

//--

$result['operations'] = [
    ['class' => $cfg['edit.button'], 'icon' => $cfg['edit.icon'], 'label' => Message::get('backend.edit')],
];

//--

require 'breadcrumb.php';

//--

$result['styles'] = [
    ['label' => Message::get('bundle.name'), 'name' => 'name', 'readonly' => true, 'type' => 'text'],
    ['label' => Message::get('bundle.remark'), 'name' => 'remark', 'readonly' => true, 'type' => 'text'],
];

//--

(new Twig('backend/list.twig'))->render($controller, $form, $result);
