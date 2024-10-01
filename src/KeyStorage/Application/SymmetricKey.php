<?php

namespace App\KeyStorage\Application;

final readonly class SymmetricKey implements Crypto
{
    public function __construct(
        private string $encryptionKey,
        private string $algorithm,
        private string $iv,
    ) { }

    public function encrypt(string $data): string
    {
        return openssl_encrypt($data, $this->algorithm, $this->encryptionKey, 0, $this->iv);
    }

    public function decrypt(string $data): string
    {
        return openssl_decrypt($data, $this->algorithm, $this->encryptionKey, 0, $this->iv);
    }
}