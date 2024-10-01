<?php

namespace App\Shared\Infrastructure\Encryption\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class KeyId
{
    public function __construct(
        private ?string $algorithm = null
    ) { }
}