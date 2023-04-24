<?php

namespace App\Application\Save;

use App\Domain\Contract\CurrencyRepositoryContract;

final class CurrencySaveUseCase
{
    public function __construct(private CurrencyRepositoryContract $currencyRepository)
    {
    }

    public function __invoke(string $base, string $rate): bool
    {
        return $this->currencyRepository->save($base, $rate);
    }
}
