<?php

namespace App\KeyStorage\Application;

final class KeyStorageFacade implements KeyStorageApi
{
    private array $keys = [];

    public function load(string $keyId): Crypto
    {
        if (!isset($this->keys[$keyId])) {
            throw new \RuntimeException('Encryption key not found');
        }

        return $this->keys[$keyId];
    }

    public function createKey(string $keyId): void
    {
        $key = openssl_random_pseudo_bytes(32);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        $this->keys[$keyId] = new SymmetricKey($key, 'aes-256-cbc', $iv);
    }
}