<?php

namespace Deimos\Flow\Extension\TPHP;

use Deimos\Flow\FlowFunction;

class TEndPHP extends FlowFunction
{

    public function view()
    {
        if (!$this->configure->isPhpEnable())
        {
            return ' -->';
        }

        return '; ?>';
    }

}