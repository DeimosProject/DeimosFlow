<?php

namespace Deimos\Flow\Extension\TTry;

use Deimos\Flow\FlowFunction;

class TCatch extends FlowFunction
{

    public function view()
    {
        array_shift($this->data);

        return sprintf('<?php } catch (\\%s) { ?>', implode($this->data));
    }

}