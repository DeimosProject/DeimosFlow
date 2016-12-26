<?php

namespace Deimos\Flow\Extension\TWhile;

use Deimos\Flow\FlowFunction;

class TWhile extends FlowFunction
{

    public function view()
    {
        return sprintf('<?php while (%s): ?>', implode($this->data));
    }

}