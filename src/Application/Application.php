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
        $this->match(static::URL_PREFIX . '/ping', 'controllers.ping:pingAction')->method('GET');
        $this->match(static::URL_PREFIX . '/users/{id}', 'controllers.user:getAction')->method('GET')->assert('id', '\d+');
        $this->match(static::URL_PREFIX . '/users', 'controllers.users:getAction')->method('GET');
        $this->match(static::URL_PREFIX . '/categories', 'controllers.categories:getAction')->method('GET');
        $this->match(static::URL_PREFIX . '/messages', 'controllers.messages:sendAction')->method('POST');
        $this->match(static::URL_PREFIX . '/autocomplete/{query}', 'controllers.autocomplete:suggestAction')->method('GET');

        $this->match(static::URL_PREFIX . '/market', 'controllers.market:getAllAction')->method('GET');
        $this->match(static::URL_PREFIX . '/market/{id}', 'controllers.market:getOneAction')->method('GET')->assert('id', '\d+');
        $this->match(static::URL_PREFIX . '/market/user/{id}', 'controllers.market:getAllByUserAction')->method('GET')->assert('id', '\d+');
        $this->match(static::URL_PREFIX . '/market/offer', 'controllers.market:createAction')->method('POST');

        $this->match(static::URL_PREFIX . '/autocomplete/{query}', 'controllers.autocomplete:suggestAction')->method('GET');


    }
}