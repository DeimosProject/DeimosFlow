<?php

namespace Deimos\Flow\Extension\TIF;

use Deimos\Flow\FlowFunction;

class TELSEIF extends FlowFunction
{
    public function view()
    {
        $storage = implode($this->data);
        $storage = $this->variable($storage);

        return sprintf('<?php elseif (%s): ?>', $storage);
    }
}