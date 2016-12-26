<?php

namespace Deimos\Flow;

abstract class FlowFunction
{

    /**
     * @var array
     */
    public $data;

    /**
     * @var Configure
     */
    public $configure;

    /**
     * FlowFunction constructor.
     *
     * @param Configure $configure
     * @param array     $data
     */
    public function __construct(Configure $configure, array $data)
    {
        $this->configure = $configure;
        $this->data      = $data;
    }

    abstract public function view();

}