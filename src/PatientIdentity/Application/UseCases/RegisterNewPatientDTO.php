<?php

namespace App\PatientIdentity\Application\UseCases;

final readonly class RegisterNewPatientDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $idSerialNumber,
        public string $email,
        public string $phoneNumber,
    ) { }
}