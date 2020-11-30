<?php

namespace App\Domain\Channel\Repository;

use App\Factory\RedisFactory;

class ChannelRepository
{

    /**
     * @var Redis
     */
    private $redis;

    /**
     * The constructor.
     *
     * @param Redis $redis The Redis Factory
     */
    public function __construct(RedisFactory $redis)
    {
        $this->redis        = $redis->createInstance();
    }

    /**
     * get is an interface for our REDIS cache
     *
     * @param string $key
     * @return array|null
     */
    public function get(string $key): ?string
    {

        $response = $this->redis->get($key);
        
        return (!empty($response)) ? $response : null;

    }

    /**
     * set is an interface for our REDIS cache
     *
     * @param string $key
     * @param string $value
     * @param string $ttl
     * @return array
     */
    public function set(string $key, string $value, int $ttl = null): array
    {

        $this->redis->set($key, $value);

        // IF $ttl is true, use TTL to set the expires time, otherwise default to 60s
        if($ttl) {
            $this->redis->expire($key, $ttl);
        } else {
            $this->redis->expire($key, 60);
        }

        return [$key => $value];
    }

    /**
     * Will push to an existing list and optionally set the ttl
     *
     * @param string $key
     * @param string $value
     * @param integer $ttl
     * @return array
     */
    public function rpush(string $key, string $value, int $ttl = null): array
    {
        $this->redis->rpush($key, $value);

        // IF $ttl is true, use TTL to set the expires time, otherwise default to 60s
        if($ttl) {
            $this->redis->expire($key, $ttl);
        } else {
            $this->redis->expire($key, 60);
        }

        return [$key => $value];
    }

    /**
     * Set a hash in redis
     *
     * @param string $id
     * @param string $key
     * @param string $value
     * @param integer $ttl
     * @return void
     */
    public function hset(string $id, string $key, string $value, int $ttl = null)
    {
        $this->redis->hset($id, $key, $value);

        // IF $ttl is true, use TTL to set the expires time, otherwise default to 60s
        if($ttl) {
            $this->redis->expire($id, $ttl);
        } else {
            $this->redis->expire($id, 60);
        }

        return [$key => $value];
    }

    /**
     * Get All Keys of a Hash
     *
     * @param string $key
     * @return void
     */
    public function hgetall(string $key)
    {
        $response = $this->redis->hgetall($key);
        return $response;
    }

    /**
     * Expires is meant to update the expiration time of a key
     *
     * @param string $key
     * @param integer $ttl
     * @return string
     */
    public function expires(string $key, int $ttl): string
    {
        $this->redis->expire($key, 60);
        return $key;
    }

    /**
     * Remove all data from Redis based on key
     *
     * @param string $key
     * @return bool
     */
    public function del(string $key): bool
    {
        $this->redis->del($key);
        return true;
    }

    /**
     * determine quickly if a key exists
     *
     * @param string $key
     * @return boolean
     */
    public function exists(string $key): bool
    {

        return ($this->redis->exists($key)) ? true : false;
        
    }

}