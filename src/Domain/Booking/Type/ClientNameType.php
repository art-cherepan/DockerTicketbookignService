<?php

namespace App\Domain\Booking\Type;

use App\Domain\Booking\Entity\ValueObject\ClientName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ClientNameType extends Type
{
    private const MYTYPE = 'clientname';

    /**
     * {@inheritdoc}
     *
     * @param string $clientNameAsString
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function convertToPHPValue($clientNameAsString, AbstractPlatform $platform): ClientName
    {
        return new ClientName($clientNameAsString);
    }

    /**
     * {@inheritdoc}
     *
     * @param ClientName $clientName
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function convertToDatabaseValue($clientName, AbstractPlatform $platform): string
    {
        return $clientName->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function getName(): string
    {
        return self::MYTYPE;
    }
}
