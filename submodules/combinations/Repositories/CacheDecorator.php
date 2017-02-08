<?php

namespace TypiCMS\Modules\Combinations\Repositories;

use TypiCMS\Modules\Core\Shells\Repositories\CacheAbstractDecorator;
use TypiCMS\Modules\Core\Shells\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements CombinationInterface
{
    public function __construct(CombinationInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
