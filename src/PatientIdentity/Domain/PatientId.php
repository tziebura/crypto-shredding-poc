<?php

namespace App\PatientIdentity\Domain;

use Stringable;
use Symfony\Component\Uid\Uuid;

final readonly class PatientId implements Stringable
{
    public function __construct(
        private Uuid $uuid,
    ) { }

    public static function new(): self
    {
        return new self(Uuid::v7());
    }

    public static function fromString(string $id): self
    {
        return new self(Uuid::fromString($id));
    }

    public function __toString(): string
    {
        return $this->uuid->toRfc4122();
    }
}