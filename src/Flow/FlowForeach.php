<?php

namespace Deimos\Flow;

class FlowForeach
{

    /**
     * @var array
     */
    protected $state = [];

    /**
     * @param string $name
     * @param array  $storage
     *
     * @throws \BadFunctionCallException
     */
    public function register($name, array $storage)
    {
        if (isset($this->state[$name]))
        {
            throw new \BadFunctionCallException('FlowForeach `' . $name . '` is readOnly!');
        }

        $this->state[$name] = new ForeachState($storage);
    }

    /**
     * @param string $name
     *
     * @return ForeachState
     */
    public function __get($name)
    {
        return $this->state[$name];
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        return call_user_func_array($this->state[$name], $arguments);
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws \BadFunctionCallException
     */
    public function __set($name, $value)
    {
        $this->register($name, $value);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->state[$name]);
    }

}