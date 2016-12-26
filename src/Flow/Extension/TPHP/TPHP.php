<?php

namespace Deimos\Flow\Extension\TPHP;

use Deimos\Flow\FlowFunction;

class TPHP extends FlowFunction
{

    public function view()
    {
        if (!$this->configure->isPhpEnable())
        {
            return '<!-- ';
        }

        return '<?php ';
    }

}