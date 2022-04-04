<?php

namespace App\Domain\Shared\Transformer\Date;

use DateTimeInterface;

/**
 * Interface DatetimeTransformerInterface
 * @package Face\Domain\Services\Transformer\Date
 */
interface DatetimeTransformerInterface
{
    public function transformToObject(string $datetime): ?DateTimeInterface;
}
