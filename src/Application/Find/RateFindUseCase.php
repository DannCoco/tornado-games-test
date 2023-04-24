<?php

namespace App\Application\Find;

use App\Domain\Rate;
use App\Domain\Contract\RateRepositoryContract;

final class RateFindUseCase 
{
    /**
     * @var RateRepositoryContract
     */
    private $rateRepository;

    public function __construct(RateRepositoryContract $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function __invoke(string $id): ?array
    {
        $rate = $this->rateRepository->findByID($id);
        if ($rate instanceof Rate) {
            return json_decode($rate->RateValue()->value(), true);
        }

        return [];
    }
}
