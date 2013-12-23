<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class Int extends TypeAbstract
{

    public function cast()
    {
        if (!$this->isValueNull() && !$this->isValueEmptyString()) {
            $this->_value = (int) $this->_value;
        }

        return $this;
    }

    public function type()
    {
        return is_int($this->_value);
    }
}