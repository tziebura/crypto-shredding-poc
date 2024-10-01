<?php

namespace App\PatientIdentity\Domain;

interface PatientRepository
{
    public function save(Patient $patient): void;
    public function existsByIdSerialNumber(string $serialNumber): bool;

    public function find(PatientId $patientId): ?Patient;
}