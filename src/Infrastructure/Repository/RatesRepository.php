<?php

namespace App\Infrastructure\Repository\Redis;

use App\Domain\Contract\RateRepositoryContract;
use App\Domain\Exception\RateNotFoundException;
use App\Domain\Rate;
use App\Domain\ValueObject\RateValue;
use Predis\Client;

final class RateRepository implements RateRepositoryContract
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

    /**
     * @param $key string
     * 
     * @return Rate|null
     * @throws RateNotFoundException
     */
    public function findByID(string $key): ?Rate
    {
        $value = $this->redisClient->get($key);
        if ($value) {
           return new Rate(new RateValue($value));
        }

        return null;
    }

    /**
     * @param $key string
     * @param $rate Rate
     * 
     * @return boolean
     */
    public function save(string $key, Rate $rate): bool 
    {
        $status = $this->redisClient->set(
            $key, 
            $rate->RateValue()->value(),
        );
        if ($status->getPayload() == self::STATUS_OK) {
            return true;
        }

        return false;
    }
}
