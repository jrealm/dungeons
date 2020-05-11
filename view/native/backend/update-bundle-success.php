<?php //>

$result['type'] = 'backward';

unset($result['data']);

resolve('raw.php')->render($controller, $form, $result);
