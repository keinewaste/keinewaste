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
        $this->match(static::URL_PREFIX . '/users', 'controllers.users:getAction')->method('GET');
        $this->match(static::URL_PREFIX . '/user', 'controllers.user:getAction')->method('GET');
        $this->match(static::URL_PREFIX . '/autocomplete/{query}', 'controllers.autocomplete:suggestAction')->method('GET');
    }
}