<?php

namespace App\Domain\Contract;


interface CurrencyRepositoryContract
{
    /**
     * @param $base string
     * 
     */
    public function findByID(string $base): ?string;

    /**
     * @param $base string
     * @param $rate array
     * 
     * @return boolean
     */
    public function save(string $base, string $rate): bool;
}