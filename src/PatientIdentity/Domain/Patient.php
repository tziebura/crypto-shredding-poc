<?php

namespace App\PatientIdentity\Domain;

use App\Shared\Infrastructure\Encryption\Attributes\Encrypt;
use App\Shared\Infrastructure\Encryption\Attributes\KeyId;

class Patient
{
    #[KeyId]
    private PatientId $id;

    #[Encrypt]
    private string $idSerialNumber;

    private string $firstName;

    private string $lastName;

    private ContactInformation $contactInformation;

    public function __construct(
        PatientId $id,
        string $idSerialNumber,
        string $firstName,
        string $lastName,
        ContactInformation $contactInformation
    )
    {
        $this->id = $id;
        $this->idSerialNumber = $idSerialNumber;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->contactInformation = $contactInformation;
    }

    public function getContactEmail(): string
    {
        return $this->contactInformation->getEmail();
    }

    public function getContactPhoneNumber(): string
    {
        return $this->contactInformation->getPhoneNumber();
    }

    public function updateContactInformation(ContactInformation $newContactInformation): void
    {
        $this->contactInformation = $newContactInformation;
    }
}