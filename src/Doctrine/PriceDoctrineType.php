<?php
declare(strict_types=1);

namespace Liox\Shop\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;
use Liox\Shop\Value\Currency;
use Liox\Shop\Value\Price;

final class PriceDoctrineType extends JsonType
{
    public const NAME = 'price';

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    /**
     * @throws ConversionException
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): Price|null
    {
        if ($value === null || $value === '[]' || $value === '{}') {
            return null;
        }

        /** @var array{} $jsonData */
        $jsonData = parent::convertToPHPValue($value, $platform);
        assert(is_array($jsonData));

        if (empty($jsonData)) {
            return null;
        }

        return new Price(
            $jsonData['value_without_vat'],
            $jsonData['vat'],
            Currency::from($jsonData['currency']),
        );
    }

    /**
     * @param null|Price $value
     * @throws ConversionException
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!is_a($value, Price::class)) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), [Price::class]);
        }

        // TODO: what about some hydrator instead of doing it manually?
        $data = [
            'value_without_vat' => $value->valueWithoutVat,
            'vat' => $value->vat,
            'currency' => $value->currency->value,
        ];

        $converted = parent::convertToDatabaseValue($data, $platform);

        if (is_string($converted) === false && $converted !== null) {
            throw ConversionException::conversionFailedSerialization($value, 'json', 'Invalid json format');
        }

        return $converted;
    }
}
