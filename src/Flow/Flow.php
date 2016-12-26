<?php

namespace Deimos\Flow;

class Flow
{

    /**
     * @var Configure
     */
    protected $configure;

    /**
     * @var string
     */
    protected $viewPath;

    /**
     * @var string
     */
    protected $cachePath;

    /**
     * @var string
     */
    protected $view;

    /**
     * @var string
     */
    protected $curView;

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * Flow constructor.
     *
     * @param Configure $configure
     */
    public function __construct(Configure $configure)
    {
        $this->configure = $configure;
    }

    /**
     * @param string $view
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function view($view = null)
    {
        if (!$this->view)
        {
            $this->view     = $view;
            $this->viewPath = $this->configure->template() . $view . $this->configure->ext();
        }

        return $this->view;
    }

    /**
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function cachePath()
    {
        if (!$this->cachePath)
        {
            $compile   = $this->configure->compile();
            $pathCache = $compile . dirname($this->view());
            $path      = $this->configure->createDirectory($pathCache);

            $this->cachePath = $path . basename($this->view()) . '.php';
        }

        return $this->cachePath;
    }

    /**
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    protected function saveCache()
    {
        return file_put_contents($this->cachePath(), $this->compile());
    }

    /**
     * @return string
     */
    protected function curView()
    {
        if (!$this->curView)
        {
            $this->curView = file_get_contents($this->viewPath);
        }

        return $this->curView;
    }

    /**
     * @return array
     */
    protected function tokens($compile)
    {
        $tokensLexer = $this->configure->tokenizer()->lexer($compile);
        $tokens      = [];

        foreach ($tokensLexer as $command)
        {
            $tokens[$command] = $this->configure->tokenizer()->commandLexer($command);
        }

        return $tokens;
    }

    /**
     * @param $view
     *
     * @return string
     */
    protected function removeComments($view)
    {
        return preg_replace('~{\*(.*?)\*}([\s]+)?~', '', $view);
    }

    /**
     * @param $view
     *
     * @return string
     */
    protected function removePhpTags($view)
    {
        $view = preg_replace('~(<\?php)~', '<!-- ', $view);
        $view = preg_replace('~(<\?=)~', '<!-- ', $view);

        return preg_replace('~(\?>)~', ' -->', $view);
    }

    /**
     * @return mixed|string
     */
    protected function compile()
    {
        $compile = $this->removeComments($this->curView());
        $compile = $this->removePhpTags($compile);
//var_dump($this->tokens($compile));die;
        foreach ($this->tokens($compile) as $tokenName => $tokens)
        {
            $compile = str_replace(
                '{' . $tokenName . '}',
                $tokens, // magic function
                $compile
            );
        }

        return $compile;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->variables[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->variables[$name]);
    }

    /**
     * @param $view
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function render($view)
    {
        $this->view($view);
        unset($view);

        if (!file_exists($this->cachePath()) || filemtime($this->viewPath) > filemtime($this->cachePath()))
        {
            $this->saveCache();
        }

        extract($this->variables, EXTR_REFS);

        ob_start();
        include $this->cachePath();

        return ob_get_clean();
    }

}