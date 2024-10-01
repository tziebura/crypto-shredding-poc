<?php

namespace App\PatientIdentity\Infrastructure\Persistence\InMemory;

use App\PatientIdentity\Domain\ContactInformation;
use App\PatientIdentity\Domain\Patient as PatientDomainModel;
use App\PatientIdentity\Domain\PatientId;
use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\Configuration\AutoMapperConfig;

final readonly class AutomapperPlus implements PatientMapper
{
    private AutoMapper $mapper;

    public function __construct()
    {
        $config = new AutoMapperConfig();

        $config->registerMapping(PatientDomainModel::class, Patient::class)
            ->forMember('contactEmail', function (PatientDomainModel $patient) {
                return $patient->getContactEmail();
            })
            ->forMember('contactPhone', function (PatientDomainModel $patient) {
                return $patient->getContactPhoneNumber();
            });

        $config->registerMapping(Patient::class, PatientDomainModel::class)
            ->forMember('contactInformation', function (Patient $source) {
                return new ContactInformation($source->getContactEmail(), $source->getContactPhone());
            })
            ->forMember('id', function (Patient $source) {
                return PatientId::fromString($source->getId());
            });

        $this->mapper = new AutoMapper($config);
    }

    public function toDomainModel(Patient $patient): PatientDomainModel
    {
        return $this->mapper->map($patient, PatientDomainModel::class);
    }

    public function toDatabaseModel(PatientDomainModel $patient): Patient
    {
        return $this->mapper->map($patient, Patient::class);
    }
}