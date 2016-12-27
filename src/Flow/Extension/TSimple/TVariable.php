<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TVariable extends FlowFunction
{

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @param $variable
     *
     * @return string
     */
    protected function variable($variable)
    {
        $variable = preg_replace('~(\$)(.*)\.([\w-_]+)~', '$1$2[\'$3\']', $variable);

        return trim($variable, '"\' ');
    }

    /**
     * @return string
     */
    protected function callback()
    {
        $callback    = '';
        $isCallback  = array_shift($this->data) === '|';
        $isAttribute = false;
        $iteration   = 0;

        foreach ($this->data as $dataValue)
        {
            if ($isCallback)
            {

                if ($dataValue === ':')
                {
                    $isAttribute = true;
                    $isCallback  = false;
                    continue;
                }

                $callback .= $dataValue;
                continue;
            }
            else if ($isAttribute)
            {
                if ($dataValue === ':')
                {
                    $iteration++;
                    continue;
                }

                if (empty($this->attributes[$iteration]))
                {
                    $this->attributes[$iteration] = '';
                }

                $this->attributes[$iteration] .= $dataValue;
            }

            $isCallback = $dataValue === '|';
        }

        return $callback;
    }

    public function view()
    {

        $data = implode($this->data);
        preg_match('~(?<variable>' . self::REGEXP_VARIABLE . ')~', $data, $variable);

        if (empty($variable['variable']))
        {
            $variable = array_shift($this->data);
        }
        else
        {
            $variable = $variable['variable'];
        }

        $variable = $this->variable($variable);

        $callback = $this->callback();

        $isDefault = $callback === 'default';

        if (empty($callback) || $isDefault)
        {
            $callback = 'escape';
        }

        if ($isDefault && $variable{0} === '$')
        {
            $storage = sprintf(
                '(empty(%s)?$this->configure->di()->escape(%s):$this->configure->di()->escape(%s))',
                $variable,
                array_shift($this->attributes),
                $variable
            );
        }
        else
        {
            $storage = '$this->configure->di()->call(\'' . $callback . '\', ';
            $export  = var_export(array_merge([$variable], $this->attributes), true);
            $regExp  = sprintf('~\'(%s)\'~', self::REGEXP_VARIABLE);
            $export  = preg_replace($regExp, '$1', $export);
            $storage .= str_replace(["\n", "\r"], '', $export) . ')';
        }

        return '<?php echo ' . $storage . '; ?>';
    }

}