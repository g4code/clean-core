<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class Int extends TypeAbstract
{
    public function cast()
    {
        if ($this->isValueEmptyString()){
            $this->_value = null;
        }

        if (!$this->isValueNull()) {
            $this->_value = (int) $this->_value;
        }
        return $this;
    }

    public function isValueNull()
    {
        return $this->_value === null;
    }

    public function type()
    {
        return is_int($this->_value);
    }
}