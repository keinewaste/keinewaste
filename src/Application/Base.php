<?php

namespace KeineWaste\Application;


use Silex\Application;

abstract class Base extends Application
{
    /**
     * Instantiate a new Application.
     *
     * Objects and parameters can be passed as argument to the constructor.
     *
     * @param array $values The parameters or objects.
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);

        $this->setRouting();
    }

    /**
     * Sets the routing rules
     *
     * @return void
     */
    abstract protected function setRouting();
}