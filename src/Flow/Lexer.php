<?php

namespace Deimos\Flow;

class Lexer
{

    /**
     * @var Configure $configure
     */
    protected $configure;

    /**
     * @var array
     */
    protected $data = [

        // if
        LexerConst::T_IF           => Extension\TIF\TIF::class,
        LexerConst::T_ELSEIF       => Extension\TIF\TELSEIF::class,
        LexerConst::T_ELSE         => Extension\TIF\TELSE::class,
        LexerConst::T_END_IF       => Extension\TIF\TEndIF::class,

        // for
        LexerConst::T_FOR          => Extension\TFor\TFor::class,
        LexerConst::T_END_FOR      => Extension\TFor\TEndFor::class,

        // while
        LexerConst::T_WHILE        => Extension\TWhile\TWhile::class,
        LexerConst::T_END_WHILE    => Extension\TWhile\TEndWhile::class,

        // foreach
        LexerConst::T_FOREACH      => Extension\TForeach\TForeach::class,
        LexerConst::T_FOREACH_ELSE => Extension\TForeach\TElseForeach::class,
        LexerConst::T_END_FOREACH  => Extension\TForeach\TEndForeach::class,

        // operators
        LexerConst::T_CONTINUE     => Extension\TSimple\TContinue::class,
        LexerConst::T_BREAK        => Extension\TSimple\TBreak::class,

        // PHP
        LexerConst::T_PHP          => Extension\TPHP\TPHP::class,
        LexerConst::T_END_PHP      => Extension\TPHP\TEndPHP::class,

        // ASSIGN
        LexerConst::T_ASSIGN       => Extension\TSimple\TAssign::class,

        // variable
        LexerConst::T_VARIABLE     => Extension\TSimple\TVariable::class,

        // include
        LexerConst::T_INCLUDE      => Extension\TSimple\TInclude::class,

        // extends
        LexerConst::T_EXTENDS      => Extension\TSimple\TExtends::class,

        // partial
        LexerConst::T_PARTIAL      => Extension\TSimple\TPartial::class,

        // block
        LexerConst::T_BLOCK_START  => Extension\TBlock\TBlockStart::class,
        LexerConst::T_BLOCK_END    => Extension\TBlock\TEndBlock::class,

        // try|catch|finally
        LexerConst::T_TRY          => Extension\TTry\TTry::class,
        LexerConst::T_CATCH        => Extension\TTry\TCatch::class,
        LexerConst::T_FINALLY      => Extension\TTry\TFinally::class,
        LexerConst::T_END_TRY      => Extension\TTry\TEndTry::class,

    ];

    /**
     * Lexer constructor.
     *
     * @param Configure $configure
     */
    public function __construct(Configure $configure)
    {
        $this->configure = $configure;
    }

    /**
     * @param $key
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function get($key)
    {
        if (!isset($this->data[$key]))
        {
            throw new \InvalidArgumentException('Config key "' . $key . '" not found!');
        }

        return $this->data[$key];
    }

}