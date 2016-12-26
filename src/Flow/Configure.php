<?php

namespace Deimos\Flow;

use Deimos\DI\DI;

class Configure
{

    use Traits\FileSystem;

    /**
     * @var string
     */
    protected $compile;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var Tokenizer
     */
    protected $tokenizer;

    /**
     * @var DI
     */
    protected $block;

    /**
     * @var DI
     */
    protected $di;

    /**
     * @var string
     */
    protected $ext = 'tpl';

    /**
     * @var bool
     */
    protected $phpEnable = false;

    /**
     * @var bool
     */
    protected $isDebug = false;

    /**
     * @var array
     */
    protected $variable = [];

    /**
     * Configure constructor.
     */
    public function __construct()
    {
        $this->tokenizer = new Tokenizer();
    }

    /**
     * @param DI $di
     *
     * @return DI
     */
    public function di(DI $di = null)
    {
        if (!$this->di)
        {
            $this->di = $di;
        }

        return $this->di;
    }

    /**
     * @return Block
     */
    public function block()
    {
        if (!$this->block)
        {
            $this->block = new Block();
        }

        return $this->block;
    }

    /**
     * @return Tokenizer
     */
    public function tokenizer()
    {
        return $this->tokenizer;
    }

    /**
     * @return bool
     */
    public function isPhpEnable()
    {
        return $this->phpEnable;
    }

    /**
     * @return bool
     */
    public function isDebug()
    {
        return $this->isDebug;
    }

    /**
     * set php enable
     */
    public function phpEnable()
    {
        $this->phpEnable = true;
    }

    /**
     * set php enable
     */
    public function debugEnable()
    {
        $this->isDebug = true;
    }

    /**
     * @param string $path
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function compile($path = null)
    {
        if (!$this->compile)
        {
            $this->compile = $this->createDirectory($path);
        }

        return $this->compile;
    }

    /**
     * @param $path
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function getFile($path)
    {
        $fullPath = $this->template() . $path;

        if (file_exists($fullPath))
        {
            return file_get_contents($fullPath);
        }

        return file_get_contents($path);
    }

    /**
     * @param $path
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function requireFile($path)
    {
        $flow = new Flow($this);

        return $flow->render($path);
    }

    /**
     * @param string $path
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function template($path = null)
    {
        if (!$this->template)
        {
            $this->template = $this->createDirectory($path);
        }

        return $this->template;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function ext($value = null)
    {
        if ($value)
        {
            $this->ext = $value;
        }

        return '.' . $this->ext;
    }

    public function getVariables()
    {
        return $this->variable;
    }

    public function __get($name)
    {
        return $this->getVariable($name);
    }

    public function __isset($name)
    {
        return $this->issetVariable($name);
    }

    public function __set($name, $value)
    {
        $this->setVariable($name, $value);
    }

    public function getVariable($name)
    {
        return $this->variable[$name];
    }

    public function issetVariable($name)
    {
        return isset($this->variable[$name]);
    }

    public function setVariable($name, $value)
    {
        $this->variable[$name] = $value;
    }

}