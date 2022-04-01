<?php

namespace App\Doctrine\Type;

use App\Domain\Booking\Entity\ValueObject\ClientPhoneNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ClientPhoneNumberType extends Type
{
    private const GET_TYPE_NAME = 'client_phone_number';

    /**
     * {@inheritdoc}
     *
     * @param string $clientphoneAsSting
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function convertToPHPValue($clientphoneAsSting, AbstractPlatform $platform): ClientPhoneNumber
    {
        return new ClientPhoneNumber($clientphoneAsSting);
    }

    /**
     * {@inheritdoc}
     *
     * @param ClientPhoneNumber $clientPhoneNumber
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function convertToDatabaseValue($clientPhoneNumber, AbstractPlatform $platform): string
    {
        return $clientPhoneNumber->getValue();
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
        return self::GET_TYPE_NAME;
    }
}
