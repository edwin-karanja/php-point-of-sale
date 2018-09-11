<?php

namespace App\Helpers\Cache;

interface CacheInterface
{
    public function getCache($key, $duration);

    public function clearCache($key);
}