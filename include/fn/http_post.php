<?php //>

return function ($url, $content, $headers = []) {
    if (is_array($content)) {
        $content = json_encode($content);
        $headers[] = 'Content-Type: application/json';
    }

    $options = [
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $content,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 180,
        CURLOPT_URL => $url,
    ];

    $ch = curl_init();

    curl_setopt_array($ch, $options);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        logger('http-post-error')->info($url, ['content' => $content, 'error' => curl_error($ch)]);
    } else {
        $info = curl_getinfo($ch);

        $header = substr($response, 0, $info['header_size']);
        $response = substr($response, $info['header_size']);

        if ($info['http_code'] !== 200) {
            logger('http-post-error')->info($url, ['content' => $content, 'header' => $header]);
        }
    }

    curl_close($ch);

    return $response;
};
