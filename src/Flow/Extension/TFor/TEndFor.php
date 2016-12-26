<?php

namespace Deimos\Flow\Extension\TFor;

use Deimos\Flow\FlowFunction;

class TEndFor extends FlowFunction
{

    public function view()
    {
        return '<?php endfor; ?>';
    }

}