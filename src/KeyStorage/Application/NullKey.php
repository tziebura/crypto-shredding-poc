<?php

namespace App\KeyStorage\Application;

final class NullKey implements Crypto
{

    public function encrypt(string $data): string
    {
        return $data;
    }

    public function decrypt(string $data): string
    {
        return $data;
    }
}