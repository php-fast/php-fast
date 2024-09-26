<?php
namespace System\Drivers\Cache;

class RedisCache extends Cache {

    protected $redis;

    /**
     * Kết nối đến Redis
     */
    protected function connect() {
        $this->redis = new \Redis();
        $this->redis->connect($this->config['cache_host'], $this->config['cache_port']);
        if (isset($this->config['cache_password'])) {
            $this->redis->auth($this->config['cache_password']);
        }
        $this->redis->select($this->config['cache_database']);
    }

    public function set($key, $value, $ttl = 3600) {
        return $this->redis->setex($key, $ttl, serialize($value));
    }

    public function get($key) {
        $result = $this->redis->get($key);
        return $result ? unserialize($result) : null;
    }

    public function delete($key) {
        return $this->redis->del($key) > 0;
    }

    public function has($key) {
        return $this->redis->exists($key);
    }

    public function clear() {
        return $this->redis->flushDB();
    }
}
