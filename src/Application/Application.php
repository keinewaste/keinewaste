<?php


namespace KeineWaste\Application;

/**
 * Class KeineWaste
 *
 * @package KeineWaste\Application
 */
class Application extends Base
{
    const URL_PREFIX = '/v1';

    /**
     * Set router
     */
    protected function setRouting()
    {
        //Ping
        $this->match(static::URL_PREFIX . '/ping', 'controllers.ping:pingAction')->method('GET');
    }
}