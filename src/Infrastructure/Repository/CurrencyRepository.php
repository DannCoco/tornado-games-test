<?php

namespace App\Infrastructure\Repository;

use App\Domain\Contract\CurrencyRepositoryContract;
use Doctrine\DBAL\Connection;

final class CurrencyRepository implements CurrencyRepositoryContract
{
    public function __construct(private Connection $connection)
    {
        
    }

    public function findByID(string $base): ?array
    {
        return [];
    }    

    public function save(string $base, string $rate): bool
    {
        return $this->connection->executeStatement("INSERT INTO currencies (base, rate) VALUES('$base', '$rate');");
    }    
}
