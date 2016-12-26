<?php

namespace Deimos\Flow\Traits;

trait Block
{

    /**
     * @var array
     */
    protected $blocks = [];

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var
     */
    protected $type;

    /**
     * @var bool
     */
    protected $isStarted;

    /**
     * @param string $name
     * @param string $type
     */
    public function start($name, $type = 'inner')
    {
        $this->isStarted = true;
        $this->lastName  = $name;
        $this->type      = $type;
        ob_start();
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function end()
    {
        if (!$this->isStarted)
        {
            throw new \InvalidArgumentException('Block not started!');
        }

        $this->isStarted = false;

        $result = ob_get_clean();

        if ($this->type === 'inner' || empty($this->blocks[$this->lastName]))
        {
            $this->blocks[$this->lastName] = $result;
        }
        else
        {

            if ($this->type === 'append')
            {
                $this->blocks[$this->lastName] .= $result;
            }

            if ($this->type === 'prepend')
            {
                $this->blocks[$this->lastName] = $result . $this->blocks[$this->lastName];
            }

        }

    }

    /**
     * @param string $name
     * @param string $default
     *
     * @return string
     */
    public function display($name, $default = '')
    {
        if (empty($this->blocks[$name]))
        {
            return $default;
        }

        return $this->blocks[$name];
    }

}