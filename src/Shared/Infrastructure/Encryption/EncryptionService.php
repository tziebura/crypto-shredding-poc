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

    public function encrypt(object $dbModel): object
    {
        $reflection = new ReflectionClass($dbModel);
        $properties = $reflection->getProperties();

        $toEncrypt = [];
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
                    $toEncrypt[$property->getName()] = $property->getValue($dbModel);
                    break;
                }
            }
        }

        $crypto = $this->keyStorageApi->load($encryptionKeyId, $encryptionAlgorithm);

        foreach ($toEncrypt as $propertyName => $propertyValue) {
            $setter = 'set' . ucfirst($propertyName);
            $dbModel->{$setter}($crypto->encrypt($propertyValue));
        }

        return $dbModel;
    }

    public function decrypt(object $dbModel): object
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