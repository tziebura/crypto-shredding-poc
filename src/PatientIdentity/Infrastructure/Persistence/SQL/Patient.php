<?php

namespace App\PatientIdentity\Infrastructure\Persistence\SQL;

use App\Shared\Infrastructure\Encryption\Attributes\Encrypt;
use App\Shared\Infrastructure\Encryption\Attributes\KeyId;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Patient
{
    #[KeyId]
    #[Id]
    #[Column(length: 36)]
    private string $id;

    #[Column]
    private string $firstName;

    #[Encrypt]
    #[Column]
    private string $lastName;

    #[Encrypt]
    #[Column]
    private string $idSerialNumber;

    #[Encrypt]
    #[Column]
    private string $contactEmail;

    #[Encrypt]
    #[Column]
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

    public function mergeWith(Patient $dbModel): void
    {
        $this->firstName = $dbModel->firstName;
        $this->lastName = $dbModel->lastName;
        $this->idSerialNumber = $dbModel->idSerialNumber;
        $this->contactEmail = $dbModel->contactEmail;
        $this->contactPhone = $dbModel->contactPhone;
    }
}