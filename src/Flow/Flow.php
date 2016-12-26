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
        $compile = $this->compile();
        $view    = $this->view();

        if (file_exists($view))
        {
            return file_put_contents($this->cachePath(), $compile);
        }

        throw new \InvalidArgumentException('File not found ' . $view);
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
     * @param string $compile
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function tokens($compile)
    {
        $tokensLexer = $this->configure->tokenizer()->lexer($compile);
        $tokens      = [];

        foreach ($tokensLexer as $command)
        {
            $tokens[$command] = $this->configure
                ->tokenizer()
                ->commandLexer($this->configure, $command);
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
     *
     * @throws \InvalidArgumentException
     */
    protected function compile()
    {
        $compile = $this->removeComments($this->curView());
        $compile = $this->removePhpTags($compile);

        foreach ($this->tokens($compile) as $tokenName => $tokens)
        {
            $compile = str_replace(
                '{' . $tokenName . '}',
                $tokens,
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
        return $this->configure->getVariable($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->configure->setVariable($name, $value);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return $this->configure->issetVariable($name);
    }

    /**
     * @param string $view
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function parseWithoutFullPath($view)
    {
        $this->view($view);

        if ($this->configure->isDebug() ||
            !file_exists($this->cachePath()) ||
            filemtime($this->viewPath) > filemtime($this->cachePath())
        )
        {
            $this->saveCache();
        }

        return $this->cachePath();
    }

    /**
     * @param $view
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function parse($view)
    {
        $fullPath  = $this->parseWithoutFullPath($view);
        $cachePath = realpath($this->configure->compile());

        $path = str_replace($cachePath, '', $fullPath);

        return ltrim($path, '/\\');
    }

    /**
     * @param string $view
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function render($view)
    {
        $parse30c471f6aAfBcA7085640653ee = $this->parseWithoutFullPath($view);
        unset($view);

        extract($this->configure->getVariables(), EXTR_REFS);

        ob_start();
        require $parse30c471f6aAfBcA7085640653ee;

        return ob_get_clean();
    }

}