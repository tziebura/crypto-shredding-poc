<?php

namespace App\PatientIdentity\Infrastructure\Persistence\InMemory;

use App\PatientIdentity\Domain\Patient;
use App\PatientIdentity\Domain\PatientId;
use App\PatientIdentity\Domain\PatientRepository;
use App\PatientIdentity\Infrastructure\Persistence\InMemory\Patient as PatientDbModel;
use App\Shared\Infrastructure\Encryption\EncryptionService;

final class InMemoryPatientRepository implements PatientRepository
{
    private array $patients = [];

    public function __construct(
        private PatientMapper $mapper,
    ) { }

    public function save(Patient $patient): void
    {
        $dbModel = $this->mapper->toDatabaseModel($patient);
        $this->patients[$dbModel->getId()] = $dbModel;
    }

    public function existsByIdSerialNumber(string $serialNumber): bool
    {
        return false;
    }

    public function find(PatientId $patientId): ?Patient
    {
        $dbModel = $this->patients[(string) $patientId];
        return $this->mapper->toDomainModel($dbModel);
    }
}