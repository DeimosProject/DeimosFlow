<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TContinue extends FlowFunction
{

    public function view()
    {
        return '<?php continue; ?>';
    }

}