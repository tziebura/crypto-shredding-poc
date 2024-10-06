<?php

namespace App\KeyStorage\Domain;

interface EncryptionKeyRepository
{
    public function save(EncryptionKey $key): void;
    public function delete(EncryptionKey $key): void;
    public function find(string $id): ?EncryptionKey;
}