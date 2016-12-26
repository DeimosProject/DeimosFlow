<?php

namespace Deimos\Flow\Extension\TIF;

use Deimos\Flow\FlowFunction;

class TEndIF extends FlowFunction
{
    public function view()
    {
        return sprintf('<?php endif; ?>');
    }
}