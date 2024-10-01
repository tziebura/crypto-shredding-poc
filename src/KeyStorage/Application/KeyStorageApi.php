<?php

namespace App\KeyStorage\Application;

interface KeyStorageApi
{
    public function load(string $keyId): Crypto;
    public function createKey(string $keyId): void;
}