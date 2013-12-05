<?php

namespace G4\CleanCore\Validator\Param\Type;

use G4\CleanCore\Validator\Param\Type\TypeAbstract;

class ArrayType extends TypeAbstract
{

    public function cast()
    {
        if ($this->_isNotEmptyString()) {

            $this->_value = explode($this->getArrayValueSeparator(), $this->_value);
        }

        if ($this->isValueEmptyString()) {

            $this->_value = null;
        }

        return $this;
    }

    public function type()
    {
        return is_array($this->_value);
    }

    public function validValue()
    {
        if ($this->isValidMetaSet() && is_array($this->_value)) {

            $this->_value = array_intersect($this->getValidValues(), $this->_value);
        }

        return $this;
    }

    private function _isNotEmptyString()
    {
        return !$this->isValueNull()
            && is_string($this->_value)
            && !$this->isValueEmptyString();
    }
}