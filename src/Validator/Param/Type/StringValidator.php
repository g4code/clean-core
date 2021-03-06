<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class StringValidator extends TypeAbstract
{
    public function cast()
    {
        if (!$this->isValueNull()) {
            $this->_value = is_array($this->_value) || is_object($this->_value) ? $this->_value : strval($this->_value);
        }
        return $this;
    }

    public function isValueNull()
    {
        return $this->_value === null || $this->_value === '';
    }

    public function type()
    {
        return is_string($this->_value);
    }
}