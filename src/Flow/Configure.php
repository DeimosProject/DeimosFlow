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
    public $di;

    /**
     * @var string
     */
    protected $ext = 'tpl';

    /**
     * Configure constructor.
     */
    public function __construct()
    {
        $this->tokenizer = new Tokenizer();
    }

    /**
     * @param DI $di
     */
    public function di(DI $di)
    {
        $this->di = $di;
    }

    /**
     * @return Tokenizer
     */
    public function tokenizer()
    {
        return $this->tokenizer;
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

}