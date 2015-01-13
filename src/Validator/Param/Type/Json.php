<?php

namespace G4\CleanCore\Validator\Param\Type;

class Json extends ArrayType
{
    public function cast()
    {
        if($this->_isNotEmptyString()) {
            $this->_value = json_decode($this->_value, true);
        }

        if($this->_isNotEmptyString() && json_last_error() !== JSON_ERROR_NONE) {
            throw new \G4\CleanCore\Exception\Validation($this->_name, $this->_value, $this->_meta);
        }

        if($this->isValueEmptyString()) {
            $this->_value = null;
        }

        return $this;
    }
}