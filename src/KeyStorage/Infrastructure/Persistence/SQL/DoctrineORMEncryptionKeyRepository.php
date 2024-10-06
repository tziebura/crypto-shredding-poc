<?php

namespace App\KeyStorage\Infrastructure\Persistence\SQL;

use App\KeyStorage\Domain\EncryptionKey;
use App\KeyStorage\Domain\EncryptionKeyRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineORMEncryptionKeyRepository implements EncryptionKeyRepository
{
    public function __construct(
        private EntityManagerInterface $em,
    ) { }

    public function save(EncryptionKey $key): void
    {
        $this->em->persist($key);
        $this->em->flush();
    }

    public function delete(EncryptionKey $key): void
    {
        $this->em->remove($key);
        $this->em->flush();
    }

    public function find(string $id): ?EncryptionKey
    {
        return $this->em->getRepository(EncryptionKey::class)->find($id);
    }
}