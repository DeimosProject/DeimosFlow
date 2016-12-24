<?php

namespace Deimos\Flow\Traits;

trait Tokenizer
{

    /**
     * @var bool
     */
    protected $isBrace;

    /**
     * @var bool
     */
    protected $isComment;

    /**
     * @var int
     */
    protected $commandIterator;

    /**
     * @var array
     */
    protected $commands;

    /**
     * @param $source
     *
     * @return array
     */
    protected function parseText($source)
    {
        /**
         * @var $tokens array
         */
        $tokens = token_get_all('<?php ' . $source);
        array_shift($tokens);

        return $tokens;
    }

    public function commandLexer($source)
    {
        return $this->parseText($source);
    }

    public function lexer($source)
    {
        $this->commands        = [];
        $this->commandIterator = -1;
        $this->isBrace         = false;
        $this->isComment       = false;

        foreach ($this->parseText($source) as $token)
        {
            $id   = null;
            $text = $token;
            if (!is_string($token))
            {
                list ($id, $text) = $token;
            }

            if ($this->isComment)
            {
                if ($text === '*')
                {
                    $this->isComment = false;
                }
                continue;
            }

            if ($text === '}')
            {
                $this->isBrace = false;
            }

            if ($this->isBrace)
            {
                if ($text{0} === '*')
                {
                    $this->isComment = true;
                    $this->isBrace   = false;
                    continue;
                }

                if (!isset($this->commands[$this->commandIterator]))
                {
                    $this->commands[$this->commandIterator] = '';
                }

                $this->commands[$this->commandIterator] .= $text;
            }

            if ($text === '{')
            {
                $this->isBrace = true;
                $this->commandIterator++;
            }

        }

        return $this->commands;
    }

}