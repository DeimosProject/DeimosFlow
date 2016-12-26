<?php

namespace Deimos\Flow\Extension\TIF;

use Deimos\Flow\FlowFunction;

class TIF extends FlowFunction
{
    public function view()
    {
        return sprintf('<?php if (%s): ?>', implode($this->data));
    }
}