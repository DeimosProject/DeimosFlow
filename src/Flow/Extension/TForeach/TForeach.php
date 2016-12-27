<?php

namespace Deimos\Flow\Extension\TForeach;

use Deimos\Flow\FlowFunction;

class TForeach extends FlowFunction
{

    public static $level = 0;
    public static $name  = [];

    public function view()
    {
        self::$level++;
        $separator = array_shift($this->data);

        if ($separator === ':')
        {
            self::$name[self::$level] = array_shift($this->data);
            array_shift($this->data);
        }

        $variable = array_shift($this->data);

        if ($variable{0} !== '$')
        {
            throw new \InvalidArgumentException(
                'Foreach error! 
                Not found ARRAY ' . $variable . var_export($this->data, true) . '!'
            );
        }

        $if   = sprintf('<?php if (!empty(%s)): ?>', $variable);
        $init = '';

        $regExp = sprintf(
            '~(?<variable>%s) as (?<key>%s)? ?=?>? ?(?<item>%s)~',
            self::REGEXP_VARIABLE,
            self::REGEXP_VARIABLE,
            self::REGEXP_VARIABLE
        );

        preg_match($regExp, $variable . implode($this->data), $matches);
        unset($variable);

        if (empty($matches['variable']))
        {
            throw new \InvalidArgumentException('Foreach not found variable');
        }

        if (empty($matches['item']))
        {
            throw new \InvalidArgumentException('Foreach not found item');
        }

        if (empty($matches['key']))
        {
            $matches['key'] = '$key' . $this->random() . $this->random();
        }

        if (!empty(self::$name[self::$level]))
        {
            $if .= ' <?php $this->foreach->register(\'' . self::$name[self::$level] . '\', ' . $matches['variable'] . '); ?>';
            $init = '$this->foreach->' . self::$name[self::$level] . '(' . $matches['key'] . ');';
        }

        $foreach = sprintf(
            '<?php foreach (%s as %s => %s): %s ?>',
            $matches['variable'],
            $matches['key'],
            $matches['item'],
            $init
        );

        return $if . $foreach;
    }

}