<?php //>

use dungeons\Config;
use dungeons\Message;
use dungeons\Resource;
use dungeons\view\Twig;

$cfg = Config::load('backend');
$menus = Resource::loadMenu(explode('|', $cfg['menus']));
$path = preg_replace('/\/backend\/(.*)/', '$1', $action->name());
$node = $menus[$path];

$result['title'] = $node['title'];

//--

$result['actions'] = [
    ['class' => $cfg['edit.button'], 'icon' => $cfg['edit.icon'], 'label' => Message::get('backend.edit'), 'path' => $path],
];

//--

require 'breadcrumb.php';

//--

$result['styles'] = [
    ['label' => Message::get('bundle.name'), 'name' => 'name', 'readonly' => true, 'type' => 'text'],
    ['label' => Message::get('bundle.remark'), 'name' => 'remark', 'readonly' => true, 'type' => 'text'],
];

//--

(new Twig('backend/list.twig'))->render($action, $form, $result);
