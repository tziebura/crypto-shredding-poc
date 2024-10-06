<?php

namespace App\PatientIdentity\Infrastructure\Persistence\SQL;

use App\PatientIdentity\Domain\Patient as PatientDomainModel;

interface PatientMapper
{
    public function toDomainModel(Patient $patient): PatientDomainModel;
    public function toDatabaseModel(PatientDomainModel $patient): Patient;
}