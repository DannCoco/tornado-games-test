<?php

namespace App\Application\Find;

use App\Domain\Contract\CurrencyRepositoryContract;


final class CurrencyFindUseCase
{
    public function __construct(private CurrencyRepositoryContract $currencyRepository)
    {
    }

    public function __invoke(string $base): ?string
    {
        return $this->currencyRepository->findByID($base);
    }
}
