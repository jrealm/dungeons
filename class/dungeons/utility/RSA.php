<?php //>

namespace dungeons\utility;

class RSA {

    public static function decrypt($data, $keyfile) {
        $key = openssl_pkey_get_private(file_get_contents($keyfile));

        if ($key) {
            $output = '';

            foreach (str_split(base64_decode($data), 128) as $chunk) {
                openssl_private_decrypt($chunk, $decrypt, $key);

                $output = "{$output}{$decrypt}";
            }

            openssl_free_key($key);

            return $output;
        }
    }

    public static function encrypt($data, $keyfile) {
        $key = openssl_pkey_get_public(file_get_contents($keyfile));

        if ($key) {
            $output = '';

            foreach (str_split($data, 117) as $chunk) {
                openssl_public_encrypt($chunk, $encrypt, $key);

                $output = "{$output}{$encrypt}";
            }

            openssl_free_key($key);

            return base64_encode($output);
        }
    }

}
