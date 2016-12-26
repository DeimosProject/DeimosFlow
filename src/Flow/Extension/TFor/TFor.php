<?php

namespace Deimos\Flow\Extension\TFor;

use Deimos\Flow\FlowFunction;

class TFor extends FlowFunction
{

    public function view()
    {
        return sprintf('<?php for (%s): ?>', implode($this->data));
    }

}