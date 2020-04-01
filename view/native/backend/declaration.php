<?php //>

use dungeons\{Config,Message,Resource};

$cfg = Config::load('backend');
$table = $controller->table();
$labels = Message::load("table/{$table->name()}");
$menus = Resource::loadMenu($cfg['menus']);
$path = preg_replace('/^\/backend\/(.+)$/', '$1', $controller->name());
$node = $menus[$path];

$result['title'] = $node['title'];
