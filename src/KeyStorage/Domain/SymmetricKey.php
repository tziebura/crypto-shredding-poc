<?php

namespace App\KeyStorage\Domain;

final readonly class SymmetricKey
{
    public function __construct(
        public string $encryptionKey,
        public string $algorithm,
        public string $salt,
    ) { }
}