<?php

declare(strict_types=1);

namespace App\Infrastructure\Redis;

class RedisClient
{
    private \Redis $redis;

    public function __construct(string $dsn)
    {
        $this->redis = new \Redis();
        $this->redis->connect(
            host: parse_url($dsn, PHP_URL_HOST),
            port: parse_url($dsn, PHP_URL_PORT),
        );
    }

    public function getClient(): \Redis
    {
        return $this->redis;
    }
}
