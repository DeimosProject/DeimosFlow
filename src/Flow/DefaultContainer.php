<?php

namespace Deimos\Flow;

use Deimos\Builder\Builder;
use Deimos\DI\DI;
use Deimos\Helper\Helper;

class DefaultContainer extends DI
{

    /**
     * @var \Deimos\Helper\Helper
     */
    protected $helper;

    /**
     * @var DefaultConfig
     */
    protected $config;

    /**
     * DefaultContainer constructor.
     *
     * @param DefaultConfig $config
     * @param Helper|null   $helper
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(DefaultConfig $config = null, Helper $helper = null)
    {
        if (!$helper)
        {
            $builder      = new Builder();
            $this->helper = new Helper($builder);
        }
        else
        {
            $this->helper = $helper;
        }

        $this->config = $config ?: new DefaultConfig();

        parent::__construct();
    }

    /**
     * configure
     */
    protected function configure()
    {
        foreach ($this->config->configStorage() as $callbackName => $callable)
        {
            $this->callback($callbackName, $callable);
        }

        $this->callback('json_encode', function (array $storage = null)
        {
            if (!$storage)
            {
                $storage = [];
            }

            return $this->json()->encode($storage);
        });

        $this->build('arr', function ()
        {
            return $this->helper->arr();
        });

        $this->build('str', function ()
        {
            return $this->helper->str();
        });

        $this->build('json', function ()
        {
            return $this->helper->json();
        });
    }

}