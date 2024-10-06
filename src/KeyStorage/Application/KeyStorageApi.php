<?php

namespace App\KeyStorage\Application;

use App\KeyStorage\Application\Crypto;

interface KeyStorageApi
{
    public function load(string $keyId): Crypto;
    public function createKey(string $keyId): void;

    public function deleteKey(string $id): void;
}