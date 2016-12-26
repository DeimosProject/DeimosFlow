<?php

namespace Deimos\Flow\Extension\TIF;

use Deimos\Flow\FlowFunction;

class TELSE extends FlowFunction
{
    public function view()
    {
        return sprintf('<?php else (%s): ?>', implode($this->data));
    }
}