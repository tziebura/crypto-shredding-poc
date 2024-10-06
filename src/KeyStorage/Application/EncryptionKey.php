<?php

namespace App\KeyStorage\Application;

use App\KeyStorage\Domain\SymmetricKey;

class EncryptionKey implements Crypto
{
    private function __construct(
        private string $key,
        private string $algorithm,
        private string $iv,
    ) { }

    public static function of(SymmetricKey $key): self
    {
        return new self(
            $key->encryptionKey,
            $key->algorithm,
            $key->salt,
        );
    }

    public function encrypt(string $data): string
    {
        return openssl_encrypt($data, $this->algorithm, $this->key, 0, $this->iv);
    }

    public function decrypt(string $data): string
    {
        return openssl_decrypt($data, $this->algorithm, $this->key, 0, $this->iv);
    }
}