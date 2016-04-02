<?php


namespace KeineWaste\Config;


class Endpoint extends General
{
    /**
     * Get limit
     *
     * @return int|null
     */
    public function getLimit()
    {
        return $this->get('limit');
    }

    /**
     * Get offset
     *
     * @return int|null
     */
    public function getOffset()
    {
        return $this->get('offset');
    }

    /**
     * Get TTL
     *
     * @return int|null
     */
    public function getTtl()
    {
        return $this->get('ttl');
    }
}