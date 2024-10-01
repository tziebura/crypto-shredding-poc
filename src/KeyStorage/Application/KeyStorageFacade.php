<?php

namespace App\KeyStorage\Application;

final class KeyStorageFacade implements KeyStorageApi
{
    private array $keys = [];

    public function load(string $keyId, ?string $algorithm = null): Crypto
    {
        $key = openssl_random_pseudo_bytes(32);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $key = new SymmetricKey($key, 'aes-256-cbc', $iv);

        if (!isset($this->keys[$keyId])) {
            $this->keys[$keyId] = $key;
        }

        return $this->keys[$keyId];
    }
}