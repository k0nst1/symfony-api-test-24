<?php

namespace App\Types;

use App\Enum\Geschlecht;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class GeschlechtType extends Type
{
    public const NAME = 'geschlecht';
    public const SCHEMA = 'public';

    private array $allowedValues = ['männlich', 'weiblich', 'divers'];
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return self::SCHEMA . ".\"". self::NAME . "\"";
    }

    public function getName(): string
    {
        return self::NAME;
    }


    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (!in_array($value, $this->allowedValues)) {
        throw new \InvalidArgumentException("Invalid '".$this->getName()."' value.");
        }
        return $value;
    }
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

}