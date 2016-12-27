<?php

namespace Deimos\Flow\Traits;

use Deimos\Flow\Configure;
use Deimos\Flow\Flow;
use Deimos\Flow\FlowFunction;
use Deimos\Flow\Lexer;
use Deimos\Flow\LexerConst;

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

    /**
     * @param Flow      $flow
     * @param Configure $configure
     * @param           $source
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public function commandLexer(Flow $flow, Configure $configure, $source)
    {
        $source = preg_replace('~([\s\t]+)~', ' ', $source);

        $commandParser = $this->parseText($source);

        return $this->commandParser($flow, $configure, $commandParser);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    protected function value($data)
    {
        if (is_array($data))
        {
            return $data[1];
        }

        return $data;
    }

    /**
     * @param array $commands
     *
     * @return array
     */
    protected function commandRef(array $commands)
    {
        $command = array_shift($commands);
        $command = $this->value($command);

        if (!empty($commands))
        {
            if ($command === '/')
            {
                $nextCommand = array_shift($commands);
                $nextCommand = $this->value($nextCommand);

                $command .= $nextCommand;
            }

            $test = $this->value($command[0]);

            if ($test === ' ')
            {
                array_shift($commands);
            }

            if ($test === '[')
            {
                $command .= $test;
                $squareBrackets = 1;
                while ($squareBrackets)
                {
                    $test = array_shift($commands);

                    switch ($test)
                    {
                        case ']':
                            $squareBrackets--;
                            break;

                        case '[':
                            $squareBrackets++;
                            break;
                    }

                    $command .= $test;
                }
            }

            foreach ($commands as $key => $value)
            {
                $commands[$key] = $this->value($value);
            }
        }

        return [$command, $commands];
    }

    /**
     * @param Flow      $flow
     * @param Configure $configure
     * @param array     $commands
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function commandParser(Flow $flow, Configure $configure, array $commands)
    {
        $lexer = new Lexer($configure);

        list ($command, $commands) = $this->commandRef($commands);

        if (in_array($command{0}, ['$', '\'', '"'], true))
        {
            $class    = $lexer->get(LexerConst::T_VARIABLE);
            $commands = array_merge([$command], $commands);
        }
        else
        {
            $class = $lexer->get($command);
        }

        /**
         * @var $object FlowFunction
         */
        $object = new $class($flow, $configure, $commands);

        return $object->view();
    }

    /**
     * @param $source
     *
     * @return array
     */
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