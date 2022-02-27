<?php

namespace Traits;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * ParameterBagTrait trait
 *
 * This trait defines the basic parameter usage of other classes
 */
trait ParameterBagTrait
{

    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;

    /**
     * @param null $parameters
     * @return $this
     */
    public function initialize($parameters = null)
    {
        $this->parameters = new ParameterBag($parameters);

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    protected function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }
}
