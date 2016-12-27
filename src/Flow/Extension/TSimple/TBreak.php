<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TBreak extends FlowFunction
{

    public function view()
    {
        return '<?php continue; ?>';
    }

}