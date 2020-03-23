<?php //>

use dungeons\Config;
use dungeons\Resource;

$menus = Resource::loadMenu(explode('|', Config::get('backend.menus')));
$path = preg_replace('/\/backend\/(.*)/', '$1', $action->name());

$result['type'] = 'redirect';
$result['path'] = $menus[$path]['parent'];

unset($result['data']);

require __DIR__ . '/../raw.php';
