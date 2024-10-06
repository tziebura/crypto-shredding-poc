<?php

namespace App\PatientIdentity\Application\UseCases;

final readonly class ChangePatientContactInformationDTO
{
    public function __construct(
        public string $id,
        public string $newEmail,
        public string $newPhoneNumber,
    ) { }
}