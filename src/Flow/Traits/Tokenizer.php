<?php

namespace Deimos\Flow\Traits;

trait Tokenizer
{

    /**
     * @var int
     */
    protected $brace;

    /**
     * @var int
     */
    protected $comment;

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
        $this->brace           = 0;
        $this->comment         = 0;

        foreach ($this->parseText($source) as $token)
        {
            $id   = null;
            $text = $token;
            if (!is_string($token))
            {
                list ($id, $text) = $token;
            }

            if ($this->comment)
            {
                if ($text === '*')
                {
                    $this->comment--;
                }
                continue;
            }

            if ($text === '}')
            {
                $this->brace--;
            }

            if ($this->brace)
            {
                if ($text{0} === '*')
                {
                    $this->comment++;
                    $this->brace--;
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
                $this->brace++;
                $this->commandIterator++;
            }

        }

        return $this->commands;
    }

}