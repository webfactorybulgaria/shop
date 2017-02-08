<?php

namespace TypiCMS\Modules\Products\Repositories;

use TypiCMS\Modules\Core\Shells\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Shells\Services\Cache\CacheInterface;

class PriceCacheDecorator extends CacheAbstractDecorator implements ProductPriceInterface
{
    public function __construct(ProductPriceInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
