<?php

namespace App\Traits;

use Redis;

trait ConnectionRedis
{
    public function getRedis()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        return $redis;
    }
}



