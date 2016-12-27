<?php

namespace Deimos\Flow;

class LexerConst
{

    // foreach
    const T_FOREACH      = 'foreach';
    const T_FOREACH_ELSE = 'foreachelse';
    const T_END_FOREACH  = '/foreach';

    // for
    const T_FOR     = 'for';
    const T_END_FOR = '/for';

    // while
    const T_WHILE     = 'while';
    const T_END_WHILE = '/while';

    const T_CONTINUE = 'continue';
    const T_BREAK    = 'break';

    // if|else|elseif
    const T_IF     = 'if';
    const T_ELSE   = 'else';
    const T_ELSEIF = 'elseif';
    const T_END_IF = '/if';

    // php
    const T_PHP     = 'php';
    const T_END_PHP = '/php';

    // assign
    const T_ASSIGN = 'assign';

    // variable
    const T_VARIABLE = 'variable';

    // include
    const T_INCLUDE = 'include';

    // partial
    const T_PARTIAL = 'partial';

    // extends
    const T_EXTENDS = 'extends';

    // partial
    const T_BLOCK_START = 'block';
    const T_BLOCK_END   = '/block';
    const T_BLOCK       = 'printBlock';

}