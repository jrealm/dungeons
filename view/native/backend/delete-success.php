<?php //>

$result['type'] = 'refresh';

unset($result['list']);

resolve('raw.php')->render($controller, $form, $result);
