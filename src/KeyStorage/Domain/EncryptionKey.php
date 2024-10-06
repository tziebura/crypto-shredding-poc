<?php

namespace App\KeyStorage\Domain;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
final class EncryptionKey
{
    #[Id]
    #[Column(length: 36)]
    private string $id;

    #[Column(name: '`key`')]
    private string $key;

    #[Column]
    private string $salt;

    #[Column]
    private string $algorithm;

    #[Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $ttl;

    private function __construct(string $id, string $key, string $salt, string $algorithm)
    {
        $this->id = $id;
        $this->key = $key;
        $this->salt = $salt;
        $this->algorithm = $algorithm;
        $this->createdAt = new DateTimeImmutable();
        $this->ttl = null;
    }

    public static function aes256(string $id)
    {
        $key = bin2hex(openssl_random_pseudo_bytes(32));
        $iv = bin2hex(openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')));

        return new EncryptionKey($id, $key, $iv, 'aes-256-cbc');
    }

    public function toKey(): SymmetricKey
    {
        return new SymmetricKey(
            hex2bin($this->key),
            $this->algorithm,
            hex2bin($this->salt),
        );
    }
}