<?php

namespace App\PatientIdentity\Infrastructure\Persistence\InMemory;

use App\PatientIdentity\Domain\Patient as PatientDomainModel;
use App\Shared\Infrastructure\Encryption\EncryptionService;

final readonly class EncryptionMapperDecorator implements PatientMapper
{
    public function __construct(
        private PatientMapper $inner,
        private EncryptionService $encryptionService,
    ) { }

    public function toDomainModel(Patient $patient): PatientDomainModel
    {
        $patient = $this->encryptionService->decrypt($patient);
        return $this->inner->toDomainModel($patient);
    }

    public function toDatabaseModel(PatientDomainModel $patient): Patient
    {
        $plainModel = $this->inner->toDatabaseModel($patient);
        return $this->encryptionService->encrypt($plainModel);
    }
}