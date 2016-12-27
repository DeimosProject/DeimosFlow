<?php

namespace Deimos\Flow;

class Block
{
    use Traits\Block;

    /**
     * Block constructor.
     *
     * @param Configure $configure
     */
    public function __construct(Configure $configure)
    {
        $this->configure = $configure;
    }
}