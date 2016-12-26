<?php

namespace Deimos\Flow;

abstract class FlowFunction
{
    /**
     * @var array
     */
    public $data;

    /**
     * FlowFunction constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    abstract public function view();
}