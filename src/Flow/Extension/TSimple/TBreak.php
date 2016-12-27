<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TBreak extends FlowFunction
{

    public function view()
    {
        if (!empty($this->data))
        {
            array_shift($this->data);
        }

        $d = sprintf('%d', implode($this->data));

        return '<?php break ' . ($d ? $d : 1) . '; ?>';
    }

}