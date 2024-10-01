<?php

namespace App\PatientIdentity\Application\UseCases;

use App\PatientIdentity\Domain\ContactInformation;
use App\PatientIdentity\Domain\Patient;
use App\PatientIdentity\Domain\PatientId;
use App\PatientIdentity\Domain\PatientRepository;
use RuntimeException;

final readonly class RegisterNewPatient
{
    public function __construct(
        private PatientRepository $patientRepository,
    ) { }

    public function execute(RegisterNewPatientDTO $dto): string
    {
        if ($this->patientRepository->existsByIdSerialNumber($dto->idSerialNumber)) {
            throw new RuntimeException('Patient already exists.');
        }

        $id = PatientId::new();

        $patient = new Patient(
            $id,
            $dto->idSerialNumber,
            $dto->firstName,
            $dto->lastName,
            new ContactInformation(
                $dto->email,
                $dto->phoneNumber,
            )
        );

        $this->patientRepository->save($patient);

        return (string) $id;
    }
}