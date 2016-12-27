<?php

namespace Deimos\Flow\Extension\TIF;

use Deimos\Flow\FlowFunction;

class TIF extends FlowFunction
{
    public function view()
    {
        array_shift($this->data);

        $storage = implode($this->data);
        $storage = $this->variable($storage);

        return sprintf('<?php if (%s): ?>', $storage);
    }
}