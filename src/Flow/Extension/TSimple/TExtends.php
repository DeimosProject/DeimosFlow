<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TExtends extends FlowFunction
{

    /**
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function view()
    {
        array_shift($this->data);

        if (current($this->data) === 'file')
        {
            array_shift($this->data); // file
            array_shift($this->data); // =
        }

        return '<?php $this->configure->extendsFile(\'' .
            $this->flow->selectView() . '\', ' .
            implode($this->data) .
            ');?>';
    }

}