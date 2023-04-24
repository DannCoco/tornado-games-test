<?php

namespace App\Domain\Contract;

use App\Domain\Rate;
use App\Domain\Exception\RateNotFoundException;

interface RateRepositoryContract 
{
    /**
     * @param $key string
     * 
     * @return Rate|null
     * @throws RateNotFoundException
     */
    public function findByID(string $key): ?Rate;

    /**
     * @param $key string
     * @param $rate Rate
     * 
     * @return boolean
     */
    public function save(string $key, Rate $rate): bool;
}
