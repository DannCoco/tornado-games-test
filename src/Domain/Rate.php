<?php

namespace App\Domain;

use App\Domain\ValueObject\RateValue;

final class Rate
{
    /**
     * @var RateValue
     */
    private $value;

    public function __construct(
        RateValue $value,
    ) {
        $this->value = $value;
    }

    public function RateValue(): RateValue
    {
        return $this->value;
    }
}
