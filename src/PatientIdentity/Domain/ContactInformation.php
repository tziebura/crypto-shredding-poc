<?php

namespace App\PatientIdentity\Domain;

use App\Shared\Infrastructure\Encryption\Attributes\Encrypt;

final class ContactInformation
{
    #[Encrypt]
    private string $email;

    #[Encrypt]
    private string $phoneNumber;

    public function __construct(string $email, string $phoneNumber)
    {
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}