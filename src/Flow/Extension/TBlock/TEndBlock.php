<?php

namespace Deimos\Flow\Extension\TBlock;

use Deimos\Flow\FlowFunction;

class TEndBlock extends FlowFunction
{

    public function view()
    {
        return '<?php $this->configure->block()->end(); ?>';
    }

}