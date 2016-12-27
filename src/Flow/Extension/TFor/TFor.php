<?php

namespace Deimos\Flow\Extension\TFor;

use Deimos\Flow\FlowFunction;

class TFor extends FlowFunction
{

    public function view()
    {
        array_shift($this->data);

        return sprintf('<?php for (%s): ?>', implode($this->data));
    }

}