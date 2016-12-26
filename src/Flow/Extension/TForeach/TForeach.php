<?php

namespace Deimos\Flow\Extension\TForeach;

use Deimos\Flow\FlowFunction;

class TForeach extends FlowFunction
{

    public function view()
    {
        array_shift($this->data);
        $variable = array_shift($this->data);

        if ($variable{0} !== '$')
        {
            throw new \InvalidArgumentException(
                'Foreach error! 
                Not found ARRAY ' . $variable . var_export($this->data, true) . '!'
            );
        }

        array_shift($this->data);

        $if      = sprintf('<?php if (!empty(%s)): ?>', $variable);
        $foreach = sprintf('<?php foreach (%s %s): ?>', $variable, implode($this->data));

        return $if . $foreach;
    }

}