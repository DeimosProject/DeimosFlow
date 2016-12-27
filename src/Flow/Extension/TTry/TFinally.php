<?php

namespace Deimos\Flow\Extension\TTry;

use Deimos\Flow\FlowFunction;

class TFinally extends FlowFunction
{

    public function view()
    {
        return '<?php } finally { ?>';
    }

}