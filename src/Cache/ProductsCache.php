<?php

namespace App\Cache;

use App\Repository\ProductRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class ProductsCache
{
    public const LIFE_TIME = 5; // 5 second

    public function __construct(private CacheInterface $cache, private ProductRepository $repository)
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findProducts(): ?array
    {
        $key = 'products';
        return $this->cache->get($key, function (ItemInterface $item)
        {
            $item->expiresAfter(self::LIFE_TIME);
            return $this->repository->findAll();
        });
    }
}
