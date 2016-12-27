<?php

namespace Deimos\Flow\Traits;

use Deimos\Flow\Configure;
use Deimos\Flow\Flow;

trait Block
{

    /**
     * @var Configure
     */
    protected $configure;

    /**
     * @var array
     */
    protected $blocks = [];

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $selectView;

    /**
     * @var bool
     */
    protected $isStarted;

    /**
     * @param Flow   $flow
     * @param string $name
     * @param string $type
     */
    public function start($flow, $name, $type = 'inner')
    {
        $this->isStarted  = true;
        $this->lastName   = $name;
        $this->selectView = $flow->selectView();
        $this->type       = $type;

        if (!isset($this->blocks[$this->lastName]))
        {
            $this->blocks[$this->lastName] = '';
        }

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

        if ($this->type === 'inner')
        {
            if (
                empty($this->blocks[$this->lastName]) ||
                empty($this->configure->getExtendsAll($this->selectView))
            )
            {
                // default value
                $this->blocks[$this->lastName] = $result;
            }
        }
        else
        {

            if ($this->type === 'append')
            {
                $this->blocks[$this->lastName] .= $result;
            }

            if ($this->type === 'prepend')
            {
                $this->blocks[$this->lastName]
                    = $result . $this->blocks[$this->lastName];
            }

        }

        $this->display();

    }

    protected function display()
    {
        if (!empty($this->configure->getExtendsAll($this->selectView)))
        {
            echo $this->getBlock($this->lastName);

            return;
        }
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getBlock($name)
    {
        return $this->blocks[$name];
    }

}