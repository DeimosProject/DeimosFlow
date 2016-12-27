<?php

namespace Deimos\Flow\Extension\TTry;

use Deimos\Flow\FlowFunction;

class TTry extends FlowFunction
{

    public function view()
    {
        return '<?php try { ?>';
    }

}