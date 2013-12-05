<?php

namespace G4\CleanCore\Formatter;

use G4\CleanCore\Formatter\FormatterInterface;

abstract class FormatterAbstract implements FormatterInterface
{

    /**
     * @var mixed
     */
    protected $_resource;

    /**
     * @param mixed $response
     * @return FormatterAbstract
     */
    public function setResource($resource)
    {
        $this->_resource = $resource;
        return $this;
    }
}