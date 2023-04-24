<?php

namespace App\Application\Save;

use App\Domain\Contract\RateRepositoryContract;
use App\Domain\Rate;
use App\Domain\ValueObject\RateValue;

final class RateSaveUseCase 
{
    /**
     * @var RateRepositoryContract
     */
    private $rateRepository;

    public function __construct(RateRepositoryContract $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function __invoke(string $key, string $value): bool
    {
        return $this->rateRepository->save($key, new Rate(new RateValue($value)));
    }
}
