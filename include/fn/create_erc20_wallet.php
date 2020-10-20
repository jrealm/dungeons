<?php //>

use kornrunner\Keccak;
use Sop\CryptoEncoding\PEM;
use Sop\CryptoTypes\Asymmetric\EC\ECPrivateKey;

return function () {
    $key = openssl_pkey_new([
        'curve_name' => 'secp256k1',
        'private_key_type' => OPENSSL_KEYTYPE_EC,
    ]);

    openssl_pkey_export($key, $pem);

    $data = ECPrivateKey::fromPEM(PEM::fromString($pem))->toASN1();
    $public = bin2hex($data->at(3)->asTagged()->asExplicit()->asBitString()->string());

    return [
        'address' => '0x' . substr(Keccak::hash(hex2bin(substr($public, 2)), 256), -40),
        'public_key' => '0x' . $public,
        'private_key' => '0x' . bin2hex($data->at(1)->asOctetString()->string()),
    ];
};
