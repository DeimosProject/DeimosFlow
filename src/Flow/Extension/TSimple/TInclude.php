<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TInclude extends FlowFunction
{

    /**
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function view()
    {
        array_shift($this->data);

        return '<?php echo $this->configure->requireFile(' . implode($this->data) . ');?>';
    }

}