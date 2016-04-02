<?php


namespace KeineWaste\Services;

trait CacheableTrait
{

    /**
     * @var \Memcached
     */
    protected $memcached;

    public function setMemcached(\Memcached $memcached)
    {
        $this->memcached = $memcached;
    }
}

?>