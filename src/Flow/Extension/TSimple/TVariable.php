<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TVariable extends FlowFunction
{

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $callback;

    protected function variable($variable)
    {
        return trim($variable, '"\' ');
    }

    protected function init()
    {
        $variable = array_shift($this->data);
        $variable = $this->variable($variable);

        $this->attributes[] = &$variable;

        $callback = '';

        $isVariable = true;
        $isCallback = true;

        foreach ($this->data as $dataValue)
        {
            if ($isVariable)
            {
                if ($dataValue === '|')
                {
                    $isVariable = false;
                    continue;
                }

                $variable .= $dataValue;
            }
            else
            {
                if ($isCallback)
                {
                    if ($dataValue === ':')
                    {
                        $isCallback = false;
                        continue;
                    }

                    $callback .= $dataValue;
                }
                else if ($dataValue !== ':')
                {
                    $this->attributes[] = $this->variable($dataValue);
                }
            }
        }

        return $callback;
    }

    public function view()
    {
        $callback = $this->init();

        $isDefault = $callback === 'default';

        if (!$callback || $isDefault)
        {
            $callback = 'escape';
        }

        $variable = current($this->attributes);

        if ($isDefault && $variable{0} === '$')
        {
            array_shift($this->attributes);
            $default = array_shift($this->attributes);

            if ($default{0} !== '$')
            {
                $default = '\'' . $default . '\'';
            }

            $storage = sprintf(
                '( empty(%s) ? $this->configure->di()->escape(%s): $this->configure->di()->escape(%s) )',
                $variable,
                $default,
                $variable
            );
        }
        else
        {
            $storage = '$this->configure->di()->call(\'' . $callback . '\', ';
            $export  = var_export($this->attributes, true);
            $export  = preg_replace('~\'(\$[\w->:]+)\'~', '$1', $export);
            $storage .= str_replace(["\n", "\r"], '', $export) . ')';
        }

        return '<?php echo ' . $storage . '; ?>';
    }

}