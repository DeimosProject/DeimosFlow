<?php

namespace Deimos\Flow\Extension\TBlock;

use Deimos\Flow\FlowFunction;

class TBlockStart extends FlowFunction
{

    public function view()
    {
        array_shift($this->data);

        $values = [];

        foreach ($this->data as $key => $value)
        {
            if ($value !== ' ')
            {
                $values[] = '\'' . trim($value, '\'"') . '\'';
            }
        }

        return '<?php $this->configure->block()->start(' . implode(', ', $values) . '); ?>';
    }

}