<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TAssign extends FlowFunction
{

    /**
     * @var string
     */
    protected $variable;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * init assign
     *
     * @throws \InvalidArgumentException
     */
    public function init()
    {
        array_shift($this->data);

        if (empty($this->data))
        {
            throw new \InvalidArgumentException('Assign not found variable name');
        }

        $this->variable = array_shift($this->data);
        array_shift($this->data);

        if (empty($this->data))
        {
            throw new \InvalidArgumentException('Assign not found variable value');
        }

        $this->value = implode($this->data);
    }

    /**
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function view()
    {
        $this->init();

        return '<?php $' . $this->variable . ' = ' . $this->value . '; ?>';
    }

}