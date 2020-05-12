<?php //>

switch (@$form['form-type']) {
case 'modal':
    $result['modal'] = true;
    $result['type'] = 'refresh';
    break;
default:
    $result['backward'] = @$form['r'];
    $result['type'] = 'backward';
}

unset($result['data']);

resolve('raw.php')->render($controller, $form, $result);
