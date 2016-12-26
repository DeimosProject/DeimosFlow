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

    // if|else|elseif
    const T_IF     = 'if';
    const T_ELSE   = 'else';
    const T_ELSEIF = 'elseif';
    const T_END_IF = '/if';

    // php
    const T_PHP     = 'php';
    const T_END_PHP = '/php';

    // block
    const T_BLOCK     = 'block';
    const T_END_BLOCK = '/block';

    // assign
    const T_ASSIGN = 'assign';

    // variable
    const T_VARIABLE = 'variable';

}