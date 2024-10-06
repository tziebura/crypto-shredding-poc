<?php

namespace App\Shared\Infrastructure\Encryption\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class KeyId
{
}