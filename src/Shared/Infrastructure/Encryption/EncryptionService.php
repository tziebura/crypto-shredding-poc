<?php

namespace App\Shared\Infrastructure\Encryption;

use App\KeyStorage\Application\KeyStorageApi;
use App\Shared\Infrastructure\Encryption\Attributes\Encrypt;
use App\Shared\Infrastructure\Encryption\Attributes\KeyId;
use ReflectionClass;

final readonly class EncryptionService
{
    public function __construct(
        private KeyStorageApi $keyStorageApi
    ) { }

    /**
     * @template T
     * @param T $dbModel
     * @return T
     */
    public function encrypt($dbModel)
    {
        $reflection = new ReflectionClass($dbModel);
        $properties = $reflection->getProperties();

        $toEncrypt = [];
        $encryptionKeyId = null;

        foreach ($properties as $property) {
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                if ($attribute->getName() === KeyId::class) {
                    $encryptionKeyId = $property->getValue($dbModel);
                    break;
                }

                if ($attribute->getName() === Encrypt::class) {
                    $toEncrypt[$property->getName()] = $property->getValue($dbModel);
                    break;
                }
            }
        }

        if (null === $encryptionKeyId) {
            throw new \RuntimeException('Encryption key id not found');
        }

        $crypto = $this->keyStorageApi->load($encryptionKeyId);

        foreach ($toEncrypt as $propertyName => $propertyValue) {
            $setter = 'set' . ucfirst($propertyName);
            $dbModel->{$setter}($crypto->encrypt($propertyValue));
        }

        return $dbModel;
    }

    /**
     * @template T
     * @param T $dbModel
     * @return T
     */
    public function decrypt($dbModel)
    {
        $reflection = new ReflectionClass($dbModel);
        $properties = $reflection->getProperties();

        $toDecrypt = [];
        $encryptionKeyId = null;
        $encryptionAlgorithm = null;

        foreach ($properties as $property) {
            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                if ($attribute->getName() === KeyId::class) {
                    $encryptionKeyId = $property->getValue($dbModel);
                    $encryptionAlgorithm = $attribute->getArguments()[0] ?? null;
                    break;
                }

                if ($attribute->getName() === Encrypt::class) {
                    $toDecrypt[$property->getName()] = $property->getValue($dbModel);
                    break;
                }
            }
        }

        $crypto = $this->keyStorageApi->load($encryptionKeyId, $encryptionAlgorithm);

        foreach ($toDecrypt as $propertyName => $propertyValue) {
            $setter = 'set' . ucfirst($propertyName);
            $dbModel->{$setter}($crypto->decrypt($propertyValue));
        }

        return $dbModel;
    }
}