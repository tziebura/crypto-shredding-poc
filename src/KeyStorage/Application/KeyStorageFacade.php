<?php

namespace App\KeyStorage\Application;

use App\KeyStorage\Domain\EncryptionKey as DomainEncryptionKey;
use App\KeyStorage\Domain\EncryptionKeyRepository;

final readonly class KeyStorageFacade implements KeyStorageApi
{
    public function __construct(
        private EncryptionKeyRepository $encryptionKeyRepository,
    ) { }

    public function load(string $keyId): Crypto
    {
        $encryptionKey = $this->encryptionKeyRepository->find($keyId);

        if (null === $encryptionKey) {
            return new NullKey();
        }

        return EncryptionKey::of($encryptionKey->toKey());
    }

    public function createKey(string $keyId): void
    {
        $encryptionKey = DomainEncryptionKey::aes256($keyId);
        $this->encryptionKeyRepository->save($encryptionKey);
    }

    public function deleteKey(string $id): void
    {
        $encryptionKey = $this->encryptionKeyRepository->find($id);

        if (null === $encryptionKey) {
            throw new \RuntimeException(sprintf('Key "%s" not found.', $id));
        }

        $this->encryptionKeyRepository->delete($encryptionKey);
    }
}