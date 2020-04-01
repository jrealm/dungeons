<?php //>

$result['type'] = 'redirect';
$result['path'] = preg_replace('/^\/backend\/(.+)\/[\w]+$/', '$1', $action->path());

unset($result['data']);

require __DIR__ . '/../raw.php';
