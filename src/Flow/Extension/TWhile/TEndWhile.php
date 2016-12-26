<?php

namespace Deimos\Flow\Extension\TWhile;

use Deimos\Flow\FlowFunction;

class TEndWhile extends FlowFunction
{

    public function view()
    {
        return '<?php endwhile; ?>';
    }

}