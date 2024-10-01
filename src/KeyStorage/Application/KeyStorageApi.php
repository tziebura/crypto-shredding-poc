<?php

namespace App\KeyStorage\Application;

interface KeyStorageApi
{
    public function load(string $keyId, ?string $algorithm = null): Crypto;
}