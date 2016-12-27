<?php

namespace Deimos\Flow\Extension\TLiteral;

use Deimos\Flow\FlowFunction;

class TLiteral extends FlowFunction
{

    public function view()
    {
        return '<?php echo \'' . str_replace('\'', '\\\'', implode($this->data)) . '\'; ?>';
    }

}