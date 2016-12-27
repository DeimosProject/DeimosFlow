<?php

namespace Deimos\Flow\Extension\TWhile;

use Deimos\Flow\FlowFunction;

class TWhile extends FlowFunction
{

    public function view()
    {
        array_shift($this->data);

        return sprintf('<?php while (%s): ?>', implode($this->data));
    }

}