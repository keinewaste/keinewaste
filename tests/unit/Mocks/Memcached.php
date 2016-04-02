<?php


namespace KeineWaste\Tests\Mocks;

class Memcached extends \Memcached
{

    /**
     * @var int
     */
    protected $lastCode;

    /**
     * @var array
     */
    protected static $dataStore = [];

    public function __construct()
    {
    }

    public function get($key, $cache_cb = null, &$cas_token = null, &$udf_flags = null)
    {
        if (isset(self::$dataStore[$key])) {
            $this->lastCode = \Memcached::RES_SUCCESS;
            return self::$dataStore[$key];
        }

        $this->lastCode = \Memcached::RES_NOTFOUND;
        return false;
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param null   $expiration
     *
     * @return bool
     */
    public function set($key, $value, $expiration = null)
    {
        self::$dataStore[$key] = $value;
        $this->lastCode        = \Memcached::RES_SUCCESS;
        return true;
    }

    public function delete($key, $time = 0)
    {
        if (isset(self::$dataStore[$key])) {
            unset(self::$dataStore[$key]);
            $this->lastCode = \Memcached::RES_SUCCESS;
        } else {
            $this->lastCode = \Memcached::RES_NOTFOUND;
        }
        return true;
    }

    public function setMulti(array $items, $expiration = null)
    {
        foreach ($items as $k => $v) {
            $this->set($k, $v, $expiration);
        }
        return true;
    }

    public function deleteMulti(array $keys, $time = 0)
    {
        foreach ($keys as $k) {
            $this->delete($k);
        }
        return true;
    }

    public function getResultCode()
    {
        return $this->lastCode;
    }
}