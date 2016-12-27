<?php

namespace Deimos\Flow\Extension\TSimple;

use Deimos\Flow\FlowFunction;

class TVariable extends FlowFunction
{

    /**
     * @param $variable
     *
     * @return string
     */
    protected function variable($variable)
    {
        return trim($variable, '"\' ');
    }

    /**
     * @return string
     */
    protected function callback()
    {
        $callback   = '';
        $isCallback = array_shift($this->data) === '|';

        foreach ($this->data as $dataValue)
        {
            if ($isCallback)
            {

                if ($dataValue === ':')
                {
                    break;
                }

                $callback .= $dataValue;

                continue;
            }

            $isCallback = $dataValue === '|';
        }

        return $callback;
    }

    public function view()
    {

        $data = implode($this->data);
        preg_match('~(?<variable>' . self::REGEXP_VARIABLE . ')~', $data, $variable);
        preg_match_all('~:(?<attributes>' . self::REGEXP_VARIABLE . '|[\w"\s\']+)~', $data, $attributes);

        if (empty($variable['variable']))
        {
            $variable = array_shift($this->data);
        }
        else
        {
            $variable = preg_replace('~([\w]+)\.([\w]+)~', '$1[\'$2\']', $variable['variable']);
        }

        $variable = $this->variable($variable);

        $attributes = $attributes['attributes'];

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
                array_shift($attributes),
                $variable
            );
        }
        else
        {
            $storage = '$this->configure->di()->call(\'' . $callback . '\', ';
            $export  = var_export(array_merge([$variable], $attributes), true);
            $regExp  = sprintf('~\'(%s)\'~', self::REGEXP_VARIABLE);
            $export  = preg_replace($regExp, '$1', $export);
            $storage .= str_replace(["\n", "\r"], '', $export) . ')';
        }

        return '<?php echo ' . $storage . '; ?>';
    }

}