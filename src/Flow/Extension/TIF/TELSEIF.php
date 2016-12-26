<?php

namespace Deimos\Flow\Extension\TIF;

use Deimos\Flow\FlowFunction;

class TELSEIF extends FlowFunction
{
    public function view()
    {
        return sprintf('<?php elseif (%s): ?>', implode($this->data));
    }
}