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
     * @var FlowForeach
     */
    public $foreach;

    /**
     * Flow constructor.
     *
     * @param Configure $configure
     */
    public function __construct(Configure $configure = null)
    {
        if (!$configure)
        {
            $configure = new Configure();
        }

        $this->configure = $configure;
        $this->foreach   = new FlowForeach();
    }

    /**
     * @param string $path
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setTemplateDir($path)
    {
        $this->configure->template($path);

        return $this;
    }

    /**
     * @param string $path
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setCompileDir($path)
    {
        $this->configure->compile($path);

        return $this;
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
            $this->view     = preg_replace('~(\.tpl)$~', '', $view);
            $this->viewPath = $this->configure->template() . $this->view . $this->configure->ext();
        }

        return $this->view;
    }

    /**
     * @return string
     */
    public function selectView()
    {
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
        $view    = $this->viewPath;

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
    protected function lexer($compile)
    {
        return $this->configure->tokenizer()->lexer($compile);
    }

    /**
     * @param $view
     *
     * @return string
     */
    protected function removeComments($view)
    {
        return preg_replace('~{\*\X*?\*}~u', '', $view);
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
        $view = preg_replace('~(<\?)~', '<!-- ', $view);

        return preg_replace('~(\?>)~', ' -->', $view);
    }

    /**
     * @param string $view
     *
     * @return mixed
     */
    protected function literal($view)
    {
        return preg_replace_callback('~{literal}(\X+){\/literal}~mu', function ($matches)
        {
            $literal = new Extension\TLiteral\TLiteral($this, $this->configure, [$matches[1]]);

            return $literal->view();
        }, $view);
    }

    /**
     * @param string $command
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function token($command)
    {
        return $this->configure->tokenizer()
            ->commandLexer($this, $this->configure, $command);
    }

    /**
     * @param $command
     *
     * @return string
     */
    protected function quote($command)
    {
        return '~' . preg_quote($command, null) . '~';
    }

    /**
     * @param string $command
     * @param string $data
     * @param string $text
     * @param int    $limit
     *
     * @return string
     */
    protected function replace($command, $data, $text, $limit = -1)
    {
        return preg_replace($this->quote($command), $data, $text, $limit);
    }

    /**
     * @param string $command
     * @param string $data
     * @param string $text
     *
     * @return string
     */
    protected function replaceOne($command, $data, $text)
    {
        return $this->replace($command, $data, $text, 1);
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
        $compile = $this->literal($compile);

        foreach ($this->lexer($compile) as $command)
        {
            $compile = $this->replaceOne(
                '{' . $command . '}',
                $this->token($command),
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
        $this->assign($name, $value);
    }

    /**
     * @param $name
     * @param $value
     */
    public function assign($name, $value)
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
    public function checkView($view)
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
        $fullPath  = $this->checkView($view);
        $cachePath = realpath($this->configure->compile());

        $path = str_replace($cachePath, '', $fullPath);

        return ltrim($path, '/\\');
    }

    /**
     * @return int
     */
    public function random()
    {
        if (function_exists('random_int'))
        {
            return random_int(0, PHP_INT_MAX);
        }

        return mt_rand(0, PHP_INT_MAX);
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
        $rand = $this->random();

        ${'____parse' . $rand} = $this->checkView($view);
        unset($view);

        extract($this->configure->getVariables(), EXTR_REFS);

        ob_start();
        require ${'____parse' . $rand};

        ${'____result' . $rand} = ob_get_clean();

        ${'____extends' . $rand} = $this->configure->getExtendsFile($this->selectView(), true);

        foreach (${'____extends' . $rand} as ${'____extend' . $rand})
        {
            ${'____result' . $rand} = (new static($this->configure))
                    ->render(${'____extend' . $rand}) . ${'____result' . $rand};
        }

        return ${'____result' . $rand};
    }

}