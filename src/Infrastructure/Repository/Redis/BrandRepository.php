<?php

namespace App\Infrastructure\Repository\Redis;

use App\Domain\Brand;
use App\Domain\Contract\BrandRepositoryContract;
use App\Domain\ValueObject\BrandID;
use App\Domain\ValueObject\BrandName;
use Exception;
use Predis\Client;

final class BrandRepository implements BrandRepositoryContract
{
    /**
     * @type string
     */
    const STATUS_OK = 'OK';

    /**
     * @var Client
     */
    private $redisClient;

    public function __construct(Client $client) 
    {
        $this->redisClient = $client;
    }

    public function all(): array 
    {
        return $this->redisClient->keys('*');
    }

    public function findByID(BrandID $id): Brand
    {
        $value = $this->redisClient->get($id->value());
        if ($value) {
           return new Brand($id, new BrandName($value));
        }

        return new Exception("not found");
    }

    public function save(string $key, string $value): bool 
    {
        $status = $this->redisClient->set($key, $value);
        if ($status->getPayload() == self::STATUS_OK) {
            return true;
        }
        
        return false;
    }

    public function deleteByID(BrandID $id): bool 
    {
        $value = $this->redisClient->get($id);
        if ($value) {
            return $this->redisClient->del($id);
        }  

        return false;
    }
}
