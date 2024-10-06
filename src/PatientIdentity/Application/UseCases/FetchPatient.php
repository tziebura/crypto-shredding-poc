<?php

namespace App\PatientIdentity\Application\UseCases;

use App\PatientIdentity\Domain\Patient;
use App\PatientIdentity\Domain\PatientId;
use App\PatientIdentity\Domain\PatientRepository;
use RuntimeException;

final readonly class FetchPatient
{
    public function __construct(
        private PatientRepository $patientRepository,
    ) { }

    public function execute(string $id): Patient
    {
        $patient = $this->patientRepository->find(PatientId::fromString($id));

        if (null === $patient) {
            throw new RuntimeException('Patient not found');
        }

        return $patient;
    }
}