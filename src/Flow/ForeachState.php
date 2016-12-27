<?php

namespace Deimos\Flow;

class ForeachState
{

    /**
     * @var string
     */
    protected $_iteration;

    /**
     * @var string
     */
    protected $_key;

    /**
     * @var string
     */
    protected $_firstKey;

    /**
     * @var string
     */
    protected $_lastKey;

    /**
     * @var array
     */
    protected $storage;

    /**
     * State constructor.
     *
     * @param array $storage
     */
    public function __construct(array &$storage)
    {
        $this->storage    = &$storage;
        $this->_iteration = 0;
        $this->_key       = key($storage);
        $this->_firstKey  = key($storage);

        end($storage);
        $this->_lastKey = key($storage);

        reset($storage);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$name}();
    }

    /**
     * @param $name
     * @param $value
     *
     * @throws \BadFunctionCallException
     */
    public function __set($name, $value)
    {
        throw new \BadFunctionCallException(__METHOD__);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return method_exists($this, $name);
    }

    /**
     * @return bool
     */
    public function odd()
    {
        return !$this->even();
    }

    /**
     * @return bool
     */
    public function even()
    {
        return !($this->iteration() & 1);
    }

    /**
     * @return bool
     */
    public function first()
    {
        return $this->key() === $this->firstKey();
    }

    /**
     * @return bool
     */
    public function last()
    {
        return $this->key() === $this->lastKey();
    }

    /**
     * @return int
     */
    public function iteration()
    {
        return $this->_iteration;
    }

    /**
     * @return string
     */
    public function key()
    {
        return $this->_key;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->storage[$this->key()];
    }

    /**
     * @return mixed
     */
    public function firstKey()
    {
        return $this->_firstKey;
    }

    /**
     * @return mixed
     */
    public function lastKey()
    {
        return $this->_lastKey;
    }

    /**
     * @return mixed
     */
    public function firstValue()
    {
        return $this->storage[$this->firstKey()];
    }

    /**
     * @return mixed
     */
    public function lastValue()
    {
        return $this->storage[$this->lastKey()];
    }

    /**
     * @param $key
     */
    public function __invoke($key)
    {
        $this->_iteration++;
        $this->_key = $key;
    }

}