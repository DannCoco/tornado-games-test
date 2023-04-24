<?php

namespace App\Application\Save;

use App\Domain\Contract\CurrencyRepositoryContract;
use Doctrine\DBAL\Connection;

final class CurrencySaveUseCase
{
    // /**
    //  * @var Connection
    //  */
    // private $currencyRepository;

    public function __construct(private CurrencyRepositoryContract $currencyRepository)
    {
        // $this->currencyRepository = $currencyRepository;
    }

    public function __invoke(string $base, string $rate): bool
    {
        return $this->currencyRepository->save($base, $rate);
    }
}
