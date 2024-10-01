<?php

namespace App\PatientIdentity\Infrastructure\Persistence\InMemory;

use App\Shared\Infrastructure\Encryption\Attributes\Encrypt;
use App\Shared\Infrastructure\Encryption\Attributes\KeyId;

class Patient
{
    #[KeyId]
    private string $id;

    private string $firstName;

    #[Encrypt]
    private string $lastName;

    #[Encrypt]
    private string $idSerialNumber;

    #[Encrypt]
    private string $contactEmail;

    #[Encrypt]
    private string $contactPhone;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getIdSerialNumber(): string
    {
        return $this->idSerialNumber;
    }

    public function setIdSerialNumber(string $idSerialNumber): void
    {
        $this->idSerialNumber = $idSerialNumber;
    }

    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(string $contactEmail): void
    {
        $this->contactEmail = $contactEmail;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(string $contactPhone): void
    {
        $this->contactPhone = $contactPhone;
    }
}