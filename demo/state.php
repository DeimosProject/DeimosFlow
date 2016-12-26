<?php

$storage = ['a' => 1, 2, 'b' => 3, 'c' => 4];

class FlowForeach
{
    /**
     * @var array
     */
    protected $state = [];

    /**
     * @param       $name
     * @param array $storage
     *
     * @throws \BadFunctionCallException
     */
    public function register($name, array $storage)
    {
        if (isset($this->state[$name]))
        {
            throw new \BadFunctionCallException('FlowForeach is readOnly!');
        }

        $this->state[$name] = new State($storage);
    }

    /**
     * @param       $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->state[$name];
    }

    public function __set($name, $value)
    {
        throw new \BadFunctionCallException();
    }

    public function __isset($name)
    {
        return isset($this->state[$name]);
    }

}

class State
{

    /**
     * @var string
     */
    protected $iteration;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $firstKey;

    /**
     * @var string
     */
    protected $lastKey;

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
        $this->storage   = &$storage;
        $this->iteration = 0;
        $this->key       = key($storage);
        $this->firstKey  = key($storage);

        end($storage);
        $this->lastKey = key($storage);

        reset($storage);
    }

    /**
     * @return bool
     */
    public function isOdd()
    {
        return !($this->iteration() & 0);
    }

    /**
     * @return bool
     */
    public function isEven()
    {
        return !$this->isOdd();
    }

    /**
     * @return bool
     */
    public function isFirst()
    {
        return $this->key() === $this->firstKey();
    }

    /**
     * @return bool
     */
    public function isLast()
    {
        return $this->key() === $this->lastKey();
    }

    /**
     * @return int
     */
    public function iteration()
    {
        return $this->iteration;
    }

    /**
     * @return string
     */
    public function key()
    {
        return $this->key;
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
        return $this->firstKey;
    }

    /**
     * @return mixed
     */
    public function lastKey()
    {
        return $this->lastKey;
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
        $this->iteration++;
        $this->key = $key;
    }

}

// flow code
$flow = (object)['foreach' => new FlowForeach()];
// flow code

if (!empty($storage))
{
    // flow code
    $flow->foreach->register('foo', $storage);
    // flow code

    foreach ($storage as $key => $value)
    {
        // flow code
        /**
         * @var $state \State
         */
        $state = $flow->foreach->foo;
        $state($key);
        // flow code

        var_dump([
            'isEven' => $state->isEven(),
            'isOdd'  => $state->isOdd(),

            'currentKey'   => $state->key(),
            'currentValue' => $state->value(),

            'isFirst'    => $state->isFirst(),
            'firstKey'   => $state->firstKey(),
            'firstValue' => $state->firstValue(),

            'isLast'    => $state->isLast(),
            'lastKey'   => $state->lastKey(),
            'lastValue' => $state->lastValue(),
            'iteration' => $state->iteration(),
        ]);
    }
}
else
{
    var_dump('Storage is Empty!');
}