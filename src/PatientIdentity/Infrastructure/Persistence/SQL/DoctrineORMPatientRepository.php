<?php

namespace App\PatientIdentity\Infrastructure\Persistence\SQL;

use App\PatientIdentity\Domain\Patient;
use App\PatientIdentity\Domain\PatientId;
use App\PatientIdentity\Domain\PatientRepository;
use App\PatientIdentity\Infrastructure\Persistence\SQL\Patient as PatientEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DoctrineORMPatientRepository implements PatientRepository
{
    public function __construct(
        private PatientMapper $mapper,
        private EntityManagerInterface $em,
    ) { }

    public function save(Patient $patient): void
    {
        $dbModel = $this->mapper->toDatabaseModel($patient);

        /** @var PatientEntity $entity */
        $entity = $this->em->getReference(PatientEntity::class, $dbModel->getId());

        try {
            $entity->mergeWith($dbModel);
        } catch (EntityNotFoundException) {
            $this->em->detach($entity);
            $entity = $dbModel;
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function find(PatientId $patientId): ?Patient
    {
        $dbModel = $this->em->getRepository(PatientEntity::class)->find($patientId);

        if (null === $dbModel) {
            return null;
        }

        return $this->mapper->toDomainModel($dbModel);
    }
}