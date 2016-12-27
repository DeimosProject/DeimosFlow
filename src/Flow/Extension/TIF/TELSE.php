<?php

namespace Deimos\Flow\Extension\TIF;

use Deimos\Flow\FlowFunction;

class TELSE extends FlowFunction
{
    public function view()
    {
        array_shift($this->data);

        return '<?php else: ?>';
    }
}