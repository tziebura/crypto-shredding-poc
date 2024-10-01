<?php

namespace App\KeyStorage\Application;

interface Crypto
{
    public function encrypt(string $data): string;
    public function decrypt(string $data): string;
}