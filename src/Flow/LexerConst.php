<?php

namespace Deimos\Flow;

class LexerConst
{
    const T_FOREACH      = 'foreach';       // foreach
    const T_FOREACH_ELSE = 'foreachelse';
    const T_END_FOREACH  = '/foreach';
    const T_FOR          = 'for';           // for
    const T_END_FOR      = '/for';
    const T_WHILE        = 'while';         // while
    const T_END_WHILE    = '/while';
    const T_CONTINUE     = 'continue';      // operators
    const T_BREAK        = 'break';
    const T_IF           = 'if';            // if|else|elseif
    const T_ELSE         = 'else';
    const T_ELSEIF       = 'elseif';
    const T_END_IF       = '/if';
    const T_TRY          = 'try';           // try|catch|finally
    const T_CATCH        = 'catch';
    const T_FINALLY      = 'finally';
    const T_END_TRY      = '/try';
    const T_PHP          = 'php';           // php
    const T_END_PHP      = '/php';
    const T_ASSIGN       = 'assign';        // assign
    const T_VARIABLE     = 'variable';      // variable
    const T_INCLUDE      = 'include';       // include
    const T_PARTIAL      = 'partial';       // partial
    const T_EXTENDS      = 'extends';       // extends
    const T_BLOCK_START  = 'block';         // block
    const T_BLOCK_END    = '/block';
    const T_BLOCK        = 'printBlock';
}