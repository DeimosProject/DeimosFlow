<?php

namespace Deimos\Flow\Extension\TBlock;

use Deimos\Flow\FlowFunction;

class TBlock extends FlowFunction
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

        return '<?php echo $this->configure->block()->display(' . implode(', ', $values) . '); ?>';
    }

}