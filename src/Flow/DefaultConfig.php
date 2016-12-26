<?php

namespace Deimos\Flow;

class DefaultConfig
{

    /**
     * @var array
     */
    protected $configStorage = [
        'substr'   => 'mb_substr',
        'strlen'   => 'mb_strlen',
        'count'    => 'count',
        'var_dump' => 'var_dump',
    ];

    /**
     * DefaultConfig constructor.
     */
    public function __construct()
    {
        $this->registerCallback('length', function ($storage)
        {
            if (is_string($storage))
            {
                return mb_strlen($storage);
            }

            return count($storage);
        });

        $this->registerCallback('escape', function ($string)
        {
            return htmlentities($string, ENT_QUOTES | ENT_IGNORE, 'UTF-8');
        });
    }

    /**
     * @return array
     */
    public function configStorage()
    {
        return $this->configStorage;
    }

    /**
     * @param $name
     * @param $callable
     */
    public function registerCallback($name, $callable)
    {
        $this->configStorage[$name] = $callable;
    }

}