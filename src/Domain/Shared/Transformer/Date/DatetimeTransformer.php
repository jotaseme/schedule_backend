<?php

namespace App\Domain\Shared\Transformer\Date;

use DateTime;
use DateTimeInterface;

/**
 * Class DatetimeTransformer
 * @package Face\Domain\Services\Transformer\Date
 */
class DatetimeTransformer implements DatetimeTransformerInterface
{

    protected const DATETIME_FORMAT = 'd/m/Y';
    protected const VALID_FORMAT    = [
        self::DATETIME_FORMAT,
        DateTimeInterface::RFC3339,
        DateTimeInterface::RFC3339_EXTENDED,
        DateTimeInterface::ISO8601
    ];

    /**
     * @param string $datetime
     * @return DateTimeInterface|null
     */
    public function transformToObject(string $datetime): ?DateTimeInterface
    {
        foreach (self::VALID_FORMAT as $format) {
            if ($objDatetime = DateTime::createFromFormat($format, $datetime)) {
                return $objDatetime;
            }
        }

        return null;
    }
}
