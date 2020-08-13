<?php //>

$error = $result['error'] ?? 'error.Undefined';

$result['error'] = $error;
$result['message'] = $result['message'] ?? i18n($error);

unset($result['success']);

resolve('raw.php')->render($controller, $form, $result);
