<?php //>

use dungeons\Message;

$error = $result['error'] ?? 'error.Unknown';

$result['error'] = $error;
$result['message'] = Message::get($error);

require 'raw.php';
