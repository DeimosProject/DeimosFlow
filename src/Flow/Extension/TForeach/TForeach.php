<?php

namespace Deimos\Flow\Extension\TForeach;

use Deimos\Flow\FlowFunction;

class TForeach extends FlowFunction
{

    public function view()
    {
        $name      = null;
        $separator = array_shift($this->data);

        if ($separator === ':')
        {
            $name = array_shift($this->data);
            array_shift($this->data);
        }

        $variable = array_shift($this->data);

        if ($variable{0} !== '$')
        {
            throw new \InvalidArgumentException(
                'Foreach error! 
                Not found ARRAY ' . $variable . var_export($this->data, true) . '!'
            );
        }

        $if   = sprintf('<?php if (!empty(%s)): ?>', $variable);
        $init = '';

        $storage = [];
        foreach ($this->data as $value)
        {
            if (!in_array($value, [' ', 'as', '=>'], true))
            {
                $storage[] = $value;
            }
        }

        if (count($storage) === 2)
        {
            list ($key, $value) = $storage;
        }
        else
        {
            $key   = '$key' . $this->random() . $this->random();
            $value = current($storage);
        }

        if ($name)
        {
            $if .= ' <?php $this->foreach->register(\'' . $name . '\', ' . $variable . '); ?>';
            $init = '$this->foreach->' . $name . '(' . $key . ');';
        }

        $foreach = sprintf('<?php foreach (%s as %s => %s): %s ?>', $variable, $key, $value, $init);

        return $if . $foreach;
    }

}