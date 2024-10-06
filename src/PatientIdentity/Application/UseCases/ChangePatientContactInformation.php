<?php

namespace App\PatientIdentity\Application\UseCases;

use App\PatientIdentity\Domain\ContactInformation;
use App\PatientIdentity\Domain\PatientId;
use App\PatientIdentity\Domain\PatientRepository;
use RuntimeException;

class ChangePatientContactInformation
{
    public function __construct(
        private PatientRepository $patientRepository,
    ) { }

    public function execute(ChangePatientContactInformationDTO $dto): void
    {
        $patient = $this->patientRepository->find(PatientId::fromString($dto->id));

        if (null === $patient) {
            throw new RuntimeException('Patient not found');
        }

        $patient->updateContactInformation(new ContactInformation(
            $dto->newEmail,
            $dto->newPhoneNumber
        ));

        $this->patientRepository->save($patient);
    }
}